<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Rekening;
use App\Models\Setoran;
use App\Models\Penarikan;
use App\Models\Transfer;
use App\Models\Transaksi;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\SetoranExport;
use App\Exports\PenarikanExport;
use App\Exports\TransferExport;
use App\Models\Minimum_saldo;
use Maatwebsite\Excel\Facades\Excel;


class tellerController extends Controller
{
    // ======================================================
    // DASHBOARD TELLER
    // ======================================================
    public function index()
    {
        $user = Auth::user();
        $teller = $user->petugas;

        // TOTAL TABUNGAN tetap dari model Rekening
        $totalTabungan = Rekening::sum('saldo_saat_ini');

        // SETORAN HARI INI (dari model Setoran)
        // Pastikan menggunakan nama kolom yang tepat sesuai database Anda
        $setoranHariIni = Setoran::whereDate('created_at', Carbon::today())
            ->sum('jumlah_penyetoran');

        // PENARIKAN HARI INI (dari model Penarikan)
        $penarikanHariIni = Penarikan::whereDate('created_at', Carbon::today())
            ->sum('jumlah_penarikan');

        $biayaAdminSetoran = Setoran::whereDate('created_at', Carbon::today())
            ->sum('nominal_admin');

        $biayaAdminPenarikan = Penarikan::whereDate('created_at', Carbon::today())
            ->sum('nominal_admin');

        $biayaAdminTransfer = Transfer::whereDate('created_at', Carbon::today())
            ->sum('nominal_admin');

        // TRANSAKSI TERBARU 
        // Ambil semua transaksi tanpa limit agar bisa di-paginate di view history
        $setor = Setoran::with('rekening.nasabah')->latest('created_at')->get();
        $tarik = Penarikan::with('rekening.nasabah')->latest('created_at')->get();

        // Gabungkan dan urutkan berdasarkan waktu
        $transactions = $setor->concat($tarik)->sortByDesc('created_at');

        return view('teller.dashboard', compact(
            'user',
            'teller',
            'totalTabungan',
            'setoranHariIni',
            'penarikanHariIni',
            'biayaAdminSetoran',
            'biayaAdminPenarikan',
            'biayaAdminTransfer',
            'transactions'
        ));
    }

    // ======================================================
    // ===================== SETORAN ========================
    // ======================================================

    public function exportSetoran($filter)
    {
        $query = Setoran::query();

        switch ($filter) {

            case 'hari_ini':
                $query->whereDate('created_at', Carbon::today());
                $judul = 'LAPORAN DATA SETORAN HARI INI';
                break;

            case 'minggu_ini':
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
                $judul = 'LAPORAN DATA SETORAN MINGGU INI';
                break;

            case 'bulan_ini':
                $query->whereMonth('created_at', Carbon::now()->month);
                $judul = 'LAPORAN DATA SETORAN BULAN INI';
                break;

            case 'tahun_ini':
                $query->whereYear('created_at', Carbon::now()->year);
                $judul = 'LAPORAN DATA SETORAN TAHUN INI';
                break;

            default:
                $judul = 'LAPORAN DATA SETORAN';
                break;
        }

        $data = $query->get();

    return Excel::download(
        new SetoranExport($data, $judul),
        'Setoran-' . now()->timestamp . '.xlsx'
    );
    }

    public function exportSetoranCustom(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date',
        ]);

        $data = Setoran::whereBetween(
            'created_at',
            [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]
        )->get();

        $judul = 'LAPORAN DATA SETORAN';

        return Excel::download(
            new SetoranExport($data, $judul),
            'Setoran-' .
                $request->start_date .
                '_sampai_' .
                $request->end_date .
                '.xlsx'
        );
    }


    public function cetakStruk($id)
    {
        $setoran = Setoran::with([
            'petugas',
            'transaksi'
        ])->findOrFail($id);

        $user = Auth::user();

        $pdf = Pdf::loadView(
            'teller.crud_setoran.struk',
            compact('setoran', 'user')
        );

        return $pdf->download(
            'Struk-Setoran-' .
            str_pad($setoran->id, 5, '0', STR_PAD_LEFT) .
            '.pdf'
        );
    }

    public function setoran(Request $request)
    {
        $user = Auth::user();
        $teller = $user->petugas;
        $perPage = $request->input('per_page', 10);
        $transaksi = Transaksi::where('jenis_transaksi', 'setoran')
            ->orWhere('jenis_transaksi', 'Setoran')
            ->first();

        $query = Setoran::with(['petugas', 'transaksi'])->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('nama_penyetor', 'like', '%' . $search . '%')
                    ->orWhere('id_rekening', 'like', '%' . $search . '%');
            });
        }

        $data = $query
            ->paginate($perPage)
            ->appends(['per_page' => $perPage]);

        return view('teller.setoran', compact('user', 'teller', 'data', 'transaksi', 'perPage'));
    }

public function storeSetoran(Request $request)
{
    $request->validate([
        'id_rekening'             => 'required|numeric|exists:rekening,id',
        'jumlah_penyetoran'        => 'required',
        'pilihan_biaya_transaksi' => 'required|in:Cash,Potong Saldo',
        'setoran'                 => 'required',
        'nama_penyetor'           => 'required',
        'transaksi_id'            => 'required|exists:transaksi,id',
        'nominal_admin'           => 'nullable'
    ]);

    $user = Auth::user();
    $teller = $user->petugas;

    $masterTransaksi = Transaksi::findOrFail($request->transaksi_id);
    $biayaAdmin = (int) $masterTransaksi->nominal;

    $jumlahSetoran = (int) preg_replace('/\D/', '', $request->jumlah_penyetoran);
    $pilihanBiaya = $request->pilihan_biaya_transaksi;

    // Kalkulasi saldo bersih yang akan masuk ke rekening
    $setoranMasukSaldo = ($pilihanBiaya === 'Potong Saldo') 
        ? ($jumlahSetoran - $biayaAdmin) 
        : $jumlahSetoran;

    if ($setoranMasukSaldo < 0) {
        return back()->with('error', 'Jumlah setoran tidak cukup untuk dipotong biaya admin!')->withInput();
    }

    DB::beginTransaction();
    try {
        $rekening = Rekening::lockForUpdate()->findOrFail($request->id_rekening);
        $rekening->saldo_saat_ini += $setoranMasukSaldo;
        $rekening->save();

        Setoran::create([
            'id_rekening'             => $request->id_rekening,
            'id_petugas'              => $teller->id,
            'setoran'                 => $request->setoran,
            'pilihan_biaya_transaksi' => $pilihanBiaya,
            'mata_uang'               => $request->mata_uang ?? 'IDR',
            'uang_terbilang'          => $request->uang_terbilang,
            'catatan'                => $request->catatan,
            'jumlah_penyetoran'      => $jumlahSetoran,
            'transaksi_id'            => $request->transaksi_id,
            'total_biaya'             => $jumlahSetoran + $biayaAdmin,
            'nominal_admin'           => $biayaAdmin,
            'nama_lengkap'            => $request->nama_lengkap,
            'nama_penyetor'           => $request->nama_penyetor,
            'alamat_penyetor'         => $request->alamat_penyetor,
            'no_hp_penyetor'          => $request->no_hp_penyetor,
        ]);

        DB::commit();
        return back()->with('success', 'Penyetoran berhasil disimpan!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
    }
}


public function updateSetoran(Request $request, $id)
{
    $request->validate([
        'id_rekening'             => 'required|exists:rekening,id',
        'jumlah_penyetoran'        => 'required',
        'pilihan_biaya_transaksi' => 'required|in:Cash,Potong Saldo',
        'transaksi_id'            => 'required|exists:transaksi,id'
    ]);

    DB::beginTransaction();

    try {
        $setoran = Setoran::findOrFail($id);

        $masterTransaksiLama = Transaksi::find($setoran->transaksi_id);
        $biayaAdminLama = $masterTransaksiLama ? (int)$masterTransaksiLama->nominal : 0;

        // Hitung berapa saldo yang tadinya pernah ditambahkan pada transaksi lama
        $setoranMasukSaldoLama = ($setoran->pilihan_biaya_transaksi === 'Potong Saldo') 
            ? ($setoran->jumlah_penyetoran - $biayaAdminLama) 
            : $setoran->jumlah_penyetoran;

        // 1. BALIKAN DULU SALDO REKENING LAMA
        $rekeningLama = Rekening::lockForUpdate()->findOrFail($setoran->id_rekening);
        $rekeningLama->saldo_saat_ini -= $setoranMasukSaldoLama;
        $rekeningLama->save();

        // 2. HITUNG NOMINAL DAN BIAYA ADMIN BARU
        $jumlahBaru = (int) preg_replace('/\D/', '', $request->jumlah_penyetoran);
        $masterTransaksiBaru = Transaksi::findOrFail($request->transaksi_id);
        $biayaAdminBaru = (int) $masterTransaksiBaru->nominal;
        $pilihanBiayaBaru = $request->pilihan_biaya_transaksi;

        $setoranMasukSaldoBaru = ($pilihanBiayaBaru === 'Potong Saldo') 
            ? ($jumlahBaru - $biayaAdminBaru) 
            : $jumlahBaru;

        if ($setoranMasukSaldoBaru < 0) {
            DB::rollBack();
            return back()->with('error', 'Jumlah setoran tidak cukup untuk dipotong biaya admin!')->withInput();
        }

        // 3. TAMBAHKAN SALDO KE REKENING BARU
        $rekeningBaru = Rekening::lockForUpdate()->findOrFail($request->id_rekening);
        $rekeningBaru->saldo_saat_ini += $setoranMasukSaldoBaru;
        $rekeningBaru->save();

        // 4. UPDATE DATA SETORAN
        $setoran->update([
            'id_rekening'             => $request->id_rekening,
            'nama_lengkap'            => $request->nama_lengkap,
            'jumlah_penyetoran'      => $jumlahBaru,
            'pilihan_biaya_transaksi' => $pilihanBiayaBaru,
            'transaksi_id'            => $request->transaksi_id,
            'total_biaya'             => $jumlahBaru + $biayaAdminBaru,
            'nominal_admin'           => $biayaAdminBaru,
            'setoran'                 => $request->setoran,
            'mata_uang'               => $request->mata_uang,
            'uang_terbilang'          => $request->uang_terbilang,
            'nama_penyetor'           => $request->nama_penyetor,
            'no_hp_penyetor'          => $request->no_hp_penyetor,
            'alamat_penyetor'         => $request->alamat_penyetor,
            'catatan'                => $request->catatan,
        ]);

        DB::commit();

        return back()->with('success', 'Data setoran berhasil diupdate!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal update: ' . $e->getMessage());
    }
}
    public function cariRekening($rekening)
    {
        $data = Rekening::with('nasabah')
            ->where('id', $rekening)
            ->first();

        if ($data && $data->nasabah) {

            return response()->json([
                'success' => true,
                'nama'    => $data->nasabah->nama_nasabah,
                'saldo'   => $data->saldo_saat_ini
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function searchRekening(Request $request)
    {
        $search = $request->query('query');
        if (strlen($search) < 2) {
            return response()->json([]);
        }

        $data = Rekening::with('nasabah')
            ->where('id', 'like', '%' . $search . '%')
            ->orWhereHas('nasabah', function ($q) use ($search) {
                $q->where('nama_nasabah', 'like', '%' . $search . '%');
            })
            ->limit(10)
            ->get();

        $results = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nasabah->nama_nasabah ?? '-',
                'saldo' => $item->saldo_saat_ini
            ];
        });

        return response()->json($results);
    }

    public function destroySetoran($id)
    {
        Setoran::findOrFail($id)->delete();
        return back()->with('success', 'History setoran berhasil dihapus!');
    }

    // ======================================================
    // ===================== PENARIKAN ======================
    // ======================================================

    public function exportPenarikan($filter)
    {
        $query = Penarikan::query();

        switch ($filter) {

            case 'hari_ini':
                $query->whereDate('created_at', Carbon::today());
                $judul = 'LAPORAN DATA PENARIKAN HARI INI';
                break;

            case 'minggu_ini':
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
                $judul = 'LAPORAN DATA PENARIKAN MINGGU INI';
                break;

            case 'bulan_ini':
                $query->whereMonth('created_at', Carbon::now()->month);
                $judul = 'LAPORAN DATA PENARIKAN BULAN INI';
                break;

            case 'tahun_ini':
                $query->whereYear('created_at', Carbon::now()->year);
                $judul = 'LAPORAN DATA PENARIKAN TAHUN INI';
                break;

            default:
                $judul = 'LAPORAN DATA PENARIKAN';
                break;
        }

        $data = $query->get();

        return Excel::download(
            new PenarikanExport($data, $judul),
            'Penarikan-' . $filter . '.xlsx'
        );
    }

    public function exportPenarikanCustom(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date',
        ]);

        $data = Penarikan::whereBetween(
            'created_at',
            [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]
        )->get();

        $judul = 'LAPORAN DATA PENARIKAN';

        return Excel::download(
            new PenarikanExport($data, $judul),
            'Penarikan-' .
            $request->start_date .
            '_sampai_' .
            $request->end_date .
            '.xlsx'
        );
    }


    public function cetakStrukPenarikan($id)
    {
        $penarikan = Penarikan::with([
            'petugas',
            'transaksi'
        ])->findOrFail($id);

        $user = Auth::user();

        $pdf = Pdf::loadView(
            'teller.crud_penarikan.struk',
            compact('penarikan', 'user')
        );

        return $pdf->download(
            'Struk-Penarikan-' .
                str_pad($penarikan->id, 5, '0', STR_PAD_LEFT) .
                '.pdf'
        );
    }


    public function penarikan(Request $request)
    {
        $user = Auth::user();
        $teller = $user->petugas;
        $saldoMinimum = Minimum_saldo::where('id', 1)->value('nominal');
        $perPage = $request->input('per_page', 10);
        $transaksi = Transaksi::where('jenis_transaksi', 'penarikan')->first();
        $query = Penarikan::with(['petugas', 'transaksi'])->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_penarik', 'like', '%' . $search . '%')
                    ->orWhere('id_rekening', 'like', '%' . $search . '%');
            });
        }

        $data = $query
            ->paginate($perPage)
            ->appends(['per_page' => $perPage]);

        return view('teller.penarikan', compact('user', 'teller', 'data', 'transaksi','saldoMinimum', 'perPage'));
    }

public function storePenarikan(Request $request)
{
    $request->validate([
        'id_rekening'             => 'required|exists:rekening,id',
        'jumlah_penarikan'        => 'required',
        'nama_penarik'            => 'required',
        'transaksi_id'            => 'required|exists:transaksi,id',
        'pilihan_biaya_transaksi' => 'required|in:cash,potong_saldo'
    ]);

    $user = Auth::user();
    $teller = $user->petugas;

    $jumlahPenarikan = (int) str_replace('.', '', $request->jumlah_penarikan);
    $masterTransaksi = Transaksi::findOrFail($request->transaksi_id);

    // Biaya admin selalu diambil dari data master transaksi
    $biayaAdminAsli = (int) $masterTransaksi->nominal;

    // Tentukan nominal yang memotong saldo di rekening nasabah
    $totalPotongSaldo = $jumlahPenarikan;
    if ($request->pilihan_biaya_transaksi === 'potong_saldo') {
        $totalPotongSaldo += $biayaAdminAsli;
    }

        $saldoMinimum = Minimum_saldo::where('id', 1)->value('nominal');

    DB::beginTransaction();
    try {
        $rekening = Rekening::lockForUpdate()->findOrFail($request->id_rekening);

        if (($rekening->saldo_saat_ini - $totalPotongSaldo) < $saldoMinimum) {
            DB::rollBack();
            return back()->with('error', 'Penarikan gagal! Saldo tidak cukup untuk memproses penarikan.');
        }

        $pilihanBiayaFormatted = ($request->pilihan_biaya_transaksi === 'potong_saldo') ? 'Potong Saldo' : 'Cash';

        // Potong saldo sesuai skema pilihan
        $rekening->saldo_saat_ini -= $totalPotongSaldo;
        $rekening->save();

        // Tetap catat nominal_admin & total_biaya secara utuh di database
        Penarikan::create([
            'id_rekening'             => $request->id_rekening,
            'id_petugas'              => $teller->id,
            'nama_penarik'            => $request->nama_penarik,
            'jumlah_penarikan'        => $jumlahPenarikan,
            'transaksi_id'            => $request->transaksi_id,
            'total_biaya'             => $jumlahPenarikan + $biayaAdminAsli,
            'nominal_admin'           => $biayaAdminAsli,
            'pilihan_biaya_transaksi' => $pilihanBiayaFormatted,
        ]);

        DB::commit();

        if ($request->pilihan_biaya_transaksi === 'cash') {
            return back()->with('success', 'Penarikan berhasil! Biaya admin Rp ' . number_format($biayaAdminAsli, 0, ',', '.') . ' dibayarkan tunai (saldo hanya terpotong nominal penarikan).');
        } else {
            return back()->with('success', 'Penarikan berhasil! Biaya admin otomatis memotong saldo.');
        }
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal memproses penarikan: ' . $e->getMessage());
    }
}

public function updatePenarikan(Request $request, $id)
{
    $request->validate([
        'id_rekening'             => 'required|exists:rekening,id',
        'jumlah_penarikan'        => 'required',
        'nama_penarik'            => 'required',
        'transaksi_id'            => 'required|exists:transaksi,id',
        'pilihan_biaya_transaksi' => 'required|in:cash,potong_saldo'
    ]);

    DB::beginTransaction();
    try {
        $penarikan = Penarikan::findOrFail($id);

        // 1. Rollback saldo berdasarkan skema lama
        $rekeningLama = Rekening::lockForUpdate()->findOrFail($penarikan->id_rekening);
        $potonganLama = $penarikan->jumlah_penarikan;
        if ($penarikan->pilihan_biaya_transaksi === 'potong_saldo') {
            $potonganLama += $penarikan->nominal_admin;
        }
        $rekeningLama->saldo_saat_ini += $potonganLama;
        $rekeningLama->save();

        // 2. Hitung penarikan & biaya baru
        $jumlahBaru = (int) preg_replace('/\D/', '', $request->jumlah_penarikan);
        $masterTransaksi = Transaksi::findOrFail($request->transaksi_id);
        $biayaAdmin = (int) $masterTransaksi->nominal;

        $totalPotongBaru = $jumlahBaru;
        if ($request->pilihan_biaya_transaksi === 'potong_saldo') {
            $totalPotongBaru += $biayaAdmin;
        }

        // 3. Cek & Potong saldo rekening baru
        $rekeningBaru = Rekening::lockForUpdate()->findOrFail($request->id_rekening);
        $saldoMinimum = 10000;
        $sisaSaldo = $rekeningBaru->saldo_saat_ini - $totalPotongBaru;

        if ($sisaSaldo < $saldoMinimum) {
            DB::rollBack();
            return back()->with('error', 'Update gagal! Saldo minimum harus tersisa Rp ' . number_format($saldoMinimum, 0, ',', '.'));
        }

        $rekeningBaru->saldo_saat_ini -= $totalPotongBaru;
        $rekeningBaru->save();

        // 4. Update record penarikan
        $penarikan->update([
            'id_rekening'             => $request->id_rekening,
            'nama_penarik'            => $request->nama_penarik,
            'jumlah_penarikan'        => $jumlahBaru,
            'transaksi_id'            => $request->transaksi_id,
            'nominal_admin'           => $biayaAdmin,
            'total_biaya'             => $jumlahBaru + $biayaAdmin,
            'pilihan_biaya_transaksi' => $request->pilihan_biaya_transaksi, 
        ]);

        DB::commit();
        return back()->with('success', 'Data penarikan berhasil diupdate!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal mengupdate penarikan: ' . $e->getMessage());
    }
}

    public function destroyPenarikan($id)
    {
        Penarikan::findOrFail($id)->delete();
        return back()->with('success', 'History penarikan berhasil dihapus!');
    }


    // ======================================================
    // ===================== TRANSFER =======================
    // ======================================================


    public function exportTransfer($filter)
    {
        $query = Transfer::with([
            'rekeningPengirim.nasabah',
            'rekeningPenerima.nasabah'
        ]);

        switch ($filter) {

            case 'hari_ini':
                $query->whereDate('created_at', Carbon::today());
                $judul = 'LAPORAN DATA TRANSFER HARI INI';
                break;

            case 'minggu_ini':
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
                $judul = 'LAPORAN DATA TRANSFER MINGGU INI';
                break;

            case 'bulan_ini':
                $query->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year);
                $judul = 'LAPORAN DATA TRANSFER BULAN INI';
                break;

            case 'tahun_ini':
                $query->whereYear('created_at', Carbon::now()->year);
                $judul = 'LAPORAN DATA TRANSFER TAHUN INI';
                break;

            default:
                $judul = 'LAPORAN DATA TRANSFER';
                break;
        }

        $data = $query->get();

        return Excel::download(
            new TransferExport($data, $judul),
            'Transfer-' . $filter . '.xlsx'
        );
    }

    public function exportTransferCustom(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date',
        ]);

        $data = Transfer::whereBetween('created_at', [
            Carbon::parse($request->start_date)->startOfDay(),
            Carbon::parse($request->end_date)->endOfDay(),
        ])->get();

        return Excel::download(
            new TransferExport($data, 'LAPORAN DATA TRANSFER'),
            'Transfer-' .
            $request->start_date .
            '-sampai-' .
            $request->end_date .
            '.xlsx'
        );
    }

    public function cetakStrukTransfer($id)
    {

        $transfer = Transfer::with([
            'rekeningPengirim.nasabah',
            'rekeningPenerima.nasabah',
            'petugas',
            'transaksi'
        ])->findOrFail($id);

        $user = Auth::user();

        $pdf = Pdf::loadView(
            'teller.crud_transfer.struk',
            compact('transfer', 'user')
        );

        return $pdf->download(
            'Struk-Transfer-' .
                str_pad($transfer->id, 5, '0', STR_PAD_LEFT) .
                '.pdf'
        );
    }

    public function transfer(Request $request)
    {
        $user = Auth::user();
        $teller = $user->petugas; // Ambil data teller
        $perPage = $request->input('per_page', 10);
        $transaksi = Transaksi::where('jenis_transaksi', 'transfer')
            ->orWhere('jenis_transaksi', 'Transfer')
            ->first();

        $query = Transfer::with(['petugas', 'transaksi', 'rekeningPengirim.nasabah', 'rekeningPenerima.nasabah'])->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('rekeningPengirim.nasabah', function ($subQuery) use ($search) {
                    $subQuery->where('nama_nasabah', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('rekeningPenerima.nasabah', function ($subQuery) use ($search) {
                        $subQuery->where('nama_nasabah', 'like', '%' . $search . '%');
                    })
                    ->orWhere('id_rekening_pengirim', 'like', '%' . $search . '%')
                    ->orWhere('id_rekening_penerima', 'like', '%' . $search . '%');
            });
        }

        $data = $query
            ->paginate($perPage)
            ->appends(['per_page' => $perPage]);

        return view('teller.transfer', compact('user', 'teller', 'data', 'transaksi', 'perPage'));
    }


 public function storeTransfer(Request $request)
    {
        $user = Auth::user();
        $teller = $user->petugas;

        $jumlahClean = (int) preg_replace('/\D/', '', $request->jumlah_transfer);
        $biayaClean  = (int) preg_replace('/\D/', '', $request->biaya_transaksi);
        $totalClean  = (int) preg_replace('/\D/', '', $request->total_biaya);

        $request->merge([
            'jumlah_transfer' => $jumlahClean,
            'biaya_transaksi' => $biayaClean,
            'total_biaya'     => $totalClean,
        ]);

        $request->validate([
            'id_rekening_pengirim'    => 'required|numeric|exists:rekening,id',
            'id_rekening_penerima'    => 'required|numeric|exists:rekening,id|different:id_rekening_pengirim',
            'jumlah_transfer'         => 'required|numeric|min:1',
            'pilihan_biaya_transaksi' => 'required|in:Cash,Potong Saldo',
        ]);

        $norekPengirim = $request->id_rekening_pengirim;
        $norekPenerima = $request->id_rekening_penerima;
        $nominal       = $request->jumlah_transfer;
        $biayaAdmin    = $biayaClean;
        $pilihanBiaya  = $request->pilihan_biaya_transaksi;

        // Tentukan jumlah total yang dipotong dari saldo pengirim
        $potonganPengirim = ($pilihanBiaya === 'Potong Saldo') ? ($nominal + $biayaAdmin) : $nominal;

        DB::beginTransaction();
        try {
            $pengirim = Rekening::lockForUpdate()->find($norekPengirim);
            $penerima = Rekening::lockForUpdate()->find($norekPenerima);

            if (!$pengirim || !$penerima) {
                throw new \Exception("Rekening tidak ditemukan.");
            }

            // Cek Saldo: Berdasarkan total potongan (Nominal + Biaya jika Potong Saldo)
            if ($pengirim->saldo_saat_ini < $potonganPengirim) {
                throw new \Exception("Saldo pengirim tidak cukup untuk transaksi ini.");
            }

            // Eksekusi Saldo Pengirim
            $pengirim->saldo_saat_ini -= $potonganPengirim;
            $pengirim->save();

            // Penerima tetap hanya menerima nominal transfer
            $penerima->saldo_saat_ini += $nominal;
            $penerima->save();

            // Simpan Data
            Transfer::create([
                'id_rekening_pengirim'    => $norekPengirim,
                'id_rekening_penerima'    => $norekPenerima,
                'jumlah_transfer'         => $nominal,
                'pilihan_biaya_transaksi' => $pilihanBiaya,
                'transaksi_id'            => $request->transaksi_id,
                'total_biaya'             => $nominal + $biayaAdmin,
                'nominal_admin'           => $biayaAdmin,
                'datetime'                => now(),
                'catatan'                 => $request->catatan,
                'id_petugas'              => $teller->id,
            ]);

            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses transaksi: ' . $e->getMessage())->withInput();
        }
    }
    
    public function updateTransfer(Request $request, $id)
    {
        $request->validate([
            'id_rekening_pengirim' => 'required',
            'id_rekening_penerima' => 'required',
        ]);

        $pengirimRepo = Rekening::find($request->id_rekening_pengirim);
        $penerimaRepo = Rekening::find($request->id_rekening_penerima);

        $request->merge([
            'id_rekening_pengirim' => $pengirimRepo ? $pengirimRepo->id : null,
            'id_rekening_penerima' => $penerimaRepo ? $penerimaRepo->id : null,

            'jumlah_transfer' => (int) preg_replace('/\D/', '', $request->jumlah_transfer),

            'biaya_transaksi' => (int) preg_replace('/\D/', '', $request->biaya_transaksi),

            'total_biaya' => (int) preg_replace('/\D/', '', $request->total_biaya),
        ]);

        $request->validate([
            'id_rekening_pengirim' => 'required|exists:rekening,id',
            'id_rekening_penerima' => 'required|exists:rekening,id',
            'jumlah_transfer'      => 'required|numeric|min:1000',
            'biaya_transaksi'      => 'required|numeric',
            'total_biaya'          => 'required|numeric',
            'transaksi_id'         => 'required|exists:transaksi,id',
        ], [
            'id_rekening_pengirim.exists' => 'Nomor rekening pengirim baru tidak valid!',
            'id_rekening_penerima.exists' => 'Nomor rekening penerima baru tidak valid!',
        ]);

        if ($request->id_rekening_pengirim == $request->id_rekening_penerima) {
            return back()->with(
                'error',
                'Tidak bisa transfer ke nomor rekening yang sama!'
            )->withInput();
        }

        $saldoMinimum = 10000;

        DB::beginTransaction();

        try {

            $transfer = Transfer::findOrFail($id);

            // rollback transaksi lama
            $pengirimLama = Rekening::lockForUpdate()
                ->findOrFail($transfer->id_rekening_pengirim);

            $penerimaLama = Rekening::lockForUpdate()
                ->findOrFail($transfer->id_rekening_penerima);

            if ($penerimaLama->saldo_saat_ini < $transfer->jumlah_transfer) {

                DB::rollBack();

                return back()->with(
                    'error',
                    'Saldo penerima lama tidak cukup untuk rollback transaksi.'
                )->withInput();
            }

            // kembalikan saldo pengirim lama
            $pengirimLama->saldo_saat_ini += $transfer->total_biaya;
            $pengirimLama->save();

            // tarik saldo penerima lama
            $penerimaLama->saldo_saat_ini -= $transfer->jumlah_transfer;
            $penerimaLama->save();

            // ambil rekening baru
            $pengirimBaru = Rekening::lockForUpdate()
                ->findOrFail($request->id_rekening_pengirim);

            $penerimaBaru = Rekening::lockForUpdate()
                ->findOrFail($request->id_rekening_penerima);

            // cek saldo pengirim baru
            if ($pengirimBaru->saldo_saat_ini < $request->total_biaya) {

                DB::rollBack();

                return back()->with(
                    'error',
                    'Saldo pengirim baru tidak mencukupi.'
                )->withInput();
            }

            $sisaSaldo = $pengirimBaru->saldo_saat_ini - $request->total_biaya;

            if ($sisaSaldo < $saldoMinimum) {

                DB::rollBack();

                return back()->with(
                    'error',
                    'Saldo minimum harus tersisa Rp 10.000'
                )->withInput();
            }

            // potong saldo pengirim baru
            $pengirimBaru->saldo_saat_ini -= $request->total_biaya;
            $pengirimBaru->save();

            // tambah saldo penerima baru
            $penerimaBaru->saldo_saat_ini += $request->jumlah_transfer;
            $penerimaBaru->save();

            // update data transfer
            $transfer->update([
                'id_rekening_pengirim' => $request->id_rekening_pengirim,
                'id_rekening_penerima' => $request->id_rekening_penerima,
                'jumlah_transfer'      => $request->jumlah_transfer,
                'biaya_transaksi'      => $request->biaya_transaksi,
                'total_biaya'          => $request->total_biaya,
                'transaksi_id'         => $request->transaksi_id,
                'catatan'              => $request->catatan,
            ]);

            DB::commit();

            return back();
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                'Gagal update data: ' . $e->getMessage()
            )->withInput();
        }
    }
    public function destroyTransfer($id)
    {
        Transfer::findOrFail($id)->delete();

        return back();
    }
}
