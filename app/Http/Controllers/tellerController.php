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

        // TRANSAKSI TERBARU 
        // Jika Anda ingin menggabungkan, Anda bisa menggunakan collection:
        $setor = Setoran::with('rekening.nasabah')->latest('created_at')->limit(5)->get();
        $tarik = Penarikan::with('rekening.nasabah')->latest('created_at')->limit(5)->get();

        // Gabungkan dan urutkan berdasarkan waktu
        $transactions = $setor->concat($tarik)->sortByDesc('created_at')->take(3);

        return view('teller.dashboard', compact(
            'user',
            'teller',
            'totalTabungan',
            'setoranHariIni',
            'penarikanHariIni',
            'transactions'
        ));
    }

    // ======================================================
    // ===================== SETORAN ========================
    // ======================================================
    public function setoran(Request $request)
    {
        $user = Auth::user();
        $teller = $user->petugas;

        $transaksi = Transaksi::where('jenis_transaksi', 'setoran')
                              ->orWhere('jenis_transaksi', 'Setoran')
                              ->first();
                              
        $query = Setoran::with(['petugas', 'transaksi'])->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('nama_penyetor', 'like', '%' . $search . '%');
            });
        }

        $data = $query->paginate(5)->withQueryString();

        return view('teller.setoran', compact('user', 'teller', 'data', 'transaksi'));
    }

    public function storeSetoran(Request $request)
    {
        $request->validate([
            'id_rekening'       => 'required|exists:rekening,id',
            'jumlah_penyetoran' => 'required',
            'setoran'           => 'required',
            'nama_penyetor'     => 'required',
            'transaksi_id'      => 'required|exists:transaksi,id'
        ]);

        $user = Auth::user();
        $teller = $user->petugas;

        $masterTransaksi = Transaksi::findOrFail($request->transaksi_id);
        $biayaAdmin = (int) $masterTransaksi->nominal;
        
        $jumlahSetoran = (int) preg_replace('/\D/', '', $request->jumlah_penyetoran);

        DB::beginTransaction();
        try {
            $rekening = Rekening::lockForUpdate()->findOrFail($request->id_rekening);
            $rekening->saldo_saat_ini += $jumlahSetoran;
            $rekening->save();

            Setoran::create([
                'id_rekening'       => $request->id_rekening,
                'id_petugas'        => $teller->id,
                'setoran'           => $request->setoran,
                'mata_uang'         => $request->mata_uang ?? 'IDR',
                'uang_terbilang'    => $request->uang_terbilang,
                'catatan'           => $request->catatan,
                'jumlah_penyetoran' => $jumlahSetoran,
                'transaksi_id'      => $request->transaksi_id,
                'total_biaya'       => $jumlahSetoran + $biayaAdmin,
                'nama_lengkap'      => $request->nama_lengkap,
                'nama_penyetor'     => $request->nama_penyetor,
                'alamat_penyetor'   => $request->alamat_penyetor,
                'no_hp_penyetor'    => $request->no_hp_penyetor,
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
            'id_rekening'       => 'required|exists:rekening,id',
            'jumlah_penyetoran' => 'required',
            'transaksi_id'      => 'required|exists:transaksi,id'
        ]);

        DB::beginTransaction();

        try {

            $setoran = Setoran::findOrFail($id);

            // AMBIL REKENING LAMA
            $rekeningLama = Rekening::lockForUpdate()
                ->findOrFail($setoran->id_rekening);

            // BALIKIN DULU SALDO LAMA
            $rekeningLama->saldo_saat_ini -= $setoran->jumlah_penyetoran;
            $rekeningLama->save();

            // NOMINAL BARU
            $jumlahBaru = (int) preg_replace(
                '/\D/',
                '',
                $request->jumlah_penyetoran
            );

            // REKENING BARU
            $rekeningBaru = Rekening::lockForUpdate()
                ->findOrFail($request->id_rekening);

            // TAMBAH SALDO BARU
            $rekeningBaru->saldo_saat_ini += $jumlahBaru;
            $rekeningBaru->save();

            // BIAYA ADMIN
            $masterTransaksi = Transaksi::findOrFail(
                $request->transaksi_id
            );

            $biayaAdmin = (int) $masterTransaksi->nominal;

            // UPDATE DATA SETORAN
            $setoran->update([
                'id_rekening'       => $request->id_rekening,
                'nama_lengkap'      => $request->nama_lengkap,
                'jumlah_penyetoran' => $jumlahBaru,
                'transaksi_id'      => $request->transaksi_id,
                'total_biaya'       => $jumlahBaru + $biayaAdmin,
                'setoran'           => $request->setoran,
                'mata_uang'         => $request->mata_uang,
                'uang_terbilang'    => $request->uang_terbilang,
                'nama_penyetor'     => $request->nama_penyetor,
                'no_hp_penyetor'    => $request->no_hp_penyetor,
                'alamat_penyetor'   => $request->alamat_penyetor,
                'catatan'           => $request->catatan,
            ]);

            DB::commit();

            return back()->with(
                'success',
                'Data setoran berhasil diupdate!'
            );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                'Gagal update: ' . $e->getMessage()
            );
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
        
    public function destroySetoran($id)
    {
        Setoran::findOrFail($id)->delete();
        return back()->with('success', 'History setoran berhasil dihapus!');
    }

    // ======================================================
    // ===================== PENARIKAN ======================
    // ======================================================
    public function penarikan(Request $request)
    {
        $user = Auth::user();
        $teller = $user->petugas;
        
        $transaksi = Transaksi::where('jenis_transaksi', 'penarikan')->first();
        $query = Penarikan::with(['petugas', 'transaksi'])->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_penarik', 'like', '%' . $search . '%')
                  ->orWhere('id_rekening', 'like', '%' . $search . '%');
            });
        }

        $data = $query->paginate(5)->withQueryString();

        return view('teller.penarikan', compact('user', 'teller', 'data', 'transaksi'));
    }

    public function storePenarikan(Request $request)
    {
        $request->validate([
            'id_rekening'      => 'required|exists:rekening,id',
            'jumlah_penarikan' => 'required',
            'nama_penarik'     => 'required',
            'transaksi_id'     => 'required|exists:transaksi,id'
        ]);

        $user = Auth::user();
        $teller = $user->petugas;

        $jumlahPenarikan = (int) str_replace('.', '', $request->jumlah_penarikan);
        $masterTransaksi = Transaksi::findOrFail($request->transaksi_id);
        
        // Biaya admin dipisahkan dari saldo
        $biayaAdmin = (int) $masterTransaksi->nominal;
        
        // Saldo hanya berkurang sebesar jumlah yang ditarik (bukan + biaya)
        $saldoMinimum = 1000;

        DB::beginTransaction();
        try {
            $rekening = Rekening::lockForUpdate()->findOrFail($request->id_rekening);
            
            // Cek saldo hanya berdasarkan jumlah penarikan saja
            if (($rekening->saldo_saat_ini - $jumlahPenarikan) < $saldoMinimum) {
                DB::rollBack();
                return back()->with('error', 'Penarikan gagal! Saldo tidak cukup untuk penarikan tersebut.');
            }

            // Kurangi saldo rekening HANYA dengan jumlah penarikan
            $rekening->saldo_saat_ini -= $jumlahPenarikan;
            $rekening->save();

            Penarikan::create([
                'id_rekening'      => $request->id_rekening,
                'id_petugas'       => $teller->id,
                'nama_penarik'     => $request->nama_penarik,
                'jumlah_penarikan' => $jumlahPenarikan,
                'transaksi_id'     => $request->transaksi_id,
                'biaya_transaksi'  => $biayaAdmin,
                // total_biaya bisa tetap disimpan untuk record, 
                // tapi tidak memotong saldo_saat_ini
                'total_biaya'      => $biayaAdmin, 
            ]);

            DB::commit();
            return back()->with('success', 'Penarikan berhasil! Silakan terima uang tunai sebesar Rp ' . number_format($biayaAdmin, 0, ',', '.') . ' untuk biaya admin.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses penarikan: ' . $e->getMessage());
        }
    }

    public function updatePenarikan(Request $request, $id)
    {
        $request->validate([
            'id_rekening'      => 'required|exists:rekening,id',
            'jumlah_penarikan' => 'required',
            'nama_penarik'     => 'required',
            'transaksi_id'     => 'required|exists:transaksi,id'
        ]);

        DB::beginTransaction();
        try {
            $penarikan = Penarikan::findOrFail($id);

            $rekeningLama = Rekening::lockForUpdate()->findOrFail($penarikan->id_rekening);
            $rekeningLama->saldo_saat_ini += $penarikan->total_biaya; 
            $rekeningLama->save();

            $jumlahBaru = (int) preg_replace('/\D/', '', $request->jumlah_penarikan);
            $masterTransaksi = Transaksi::findOrFail($request->transaksi_id);
            $biayaAdmin = (int) $masterTransaksi->nominal;
            $totalPotongBaru = $jumlahBaru + $biayaAdmin;

            // FIX: Definisikan $rekeningBaru terlebih dahulu bray
            $rekeningBaru = Rekening::lockForUpdate()->findOrFail($request->id_rekening);
            $saldoMinimum = 10000;
            $sisaSaldo = $rekeningBaru->saldo_saat_ini - $totalPotongBaru;

            if ($sisaSaldo < $saldoMinimum) {
                DB::rollBack();
                return back()->with('error', 'Update gagal! Saldo minimum harus tersisa Rp ' . number_format($saldoMinimum, 0, ',', '.'));
            }

            $rekeningBaru->saldo_saat_ini -= $totalPotongBaru;
            $rekeningBaru->save();

            $penarikan->update([
                'id_rekening'      => $request->id_rekening,
                'nama_penarik'     => $request->nama_penarik,
                'jumlah_penarikan' => $jumlahBaru,
                'transaksi_id'     => $request->transaksi_id,
                'biaya_transaksi'  => $biayaAdmin,
                'total_biaya'      => $totalPotongBaru,
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
    public function transfer(Request $request)
    {
        $user = Auth::user();
        $teller = $user->petugas; // Ambil data teller

        $transaksi = Transaksi::where('jenis_transaksi', 'transfer')
                            ->orWhere('jenis_transaksi', 'Transfer')
                            ->first();
                            
        $query = Transfer::with(['petugas', 'transaksi', 'rekeningPengirim.nasabah', 'rekeningPenerima.nasabah'])->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('rekeningPengirim.nasabah', function($subQuery) use ($search) {
                    $subQuery->where('nama_nasabah', 'like', '%' . $search . '%');
                })
                ->orWhereHas('rekeningPenerima.nasabah', function($subQuery) use ($search) {
                    $subQuery->where('nama_nasabah', 'like', '%' . $search . '%');
                })
                ->orWhere('id_rekening_pengirim', 'like', '%' . $search . '%')
                ->orWhere('id_rekening_penerima', 'like', '%' . $search . '%');
            });
        }

        $data = $query->paginate(5)->withQueryString();

        return view('teller.transfer', compact('user', 'teller', 'data', 'transaksi'));
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
            'id_rekening_pengirim' => 'required|exists:rekening,id',
            'id_rekening_penerima' => 'required|exists:rekening,id|different:id_rekening_pengirim',
            'jumlah_transfer'      => 'required|numeric|min:1',
        ]);

        $norekPengirim = $request->id_rekening_pengirim;
        $norekPenerima = $request->id_rekening_penerima;
        $nominal       = $request->jumlah_transfer; // Nominal yang dipotong dari saldo
        $biayaAdmin    = $biayaClean;               // Dibayar cash

        DB::beginTransaction();
        try {
            $pengirim = Rekening::lockForUpdate()->find($norekPengirim);
            $penerima = Rekening::lockForUpdate()->find($norekPenerima);

            if (!$pengirim || !$penerima) {
                throw new \Exception("Rekening tidak ditemukan.");
            }

            // Cek Saldo: Hanya berdasarkan nominal transfer saja
            if ($pengirim->saldo_saat_ini < $nominal) {
                throw new \Exception("Saldo pengirim tidak cukup untuk transfer.");
            }

            // Eksekusi Saldo: Hanya memotong nominal transfer
            $pengirim->saldo_saat_ini -= $nominal;
            $pengirim->save();

            $penerima->saldo_saat_ini += $nominal;
            $penerima->save();

            // Simpan Data
            Transfer::create([
                'id_rekening_pengirim' => $norekPengirim,
                'id_rekening_penerima' => $norekPenerima,
                'jumlah_transfer'      => $nominal,
                'transaksi_id'         => $request->transaksi_id, 
                'total_biaya'          => $nominal + $biayaAdmin, // Tetap mencatat total untuk laporan
                'datetime'             => now(), 
                'catatan'              => $request->catatan,
                'id_petugas'           => $teller->id,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Transfer berhasil! Biaya admin sebesar Rp ' . number_format($biayaAdmin, 0, ',', '.') . ' harap diterima secara tunai.');

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

            return back()->with(
                'success',
                'Data transfer berhasil diperbarui!'
            );

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
        return back()->with('success', 'History transaksi transfer berhasil dihapus!');
    }
}