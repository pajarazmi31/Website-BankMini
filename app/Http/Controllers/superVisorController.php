<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Bukti_Tf;
use App\Models\Rekening;
use App\Exports\BuktiTfExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Nasabah;
use App\Models\VerifikasiLogin;
use Carbon\Carbon;
use App\Models\Transaksi;
use App\Models\Petugas;
use App\Models\RiwayatTf;
use App\Models\Minimum_saldo;

class superVisorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $super = $user->petugas;

        // Admin Transaksi
        $adminTotal = Bukti_Tf::where('status_verifikasi', 'berhasil')->sum('nominal_admin');
        $adminAntarNasabah = RiwayatTf::get()->sum('nominal_admin');

        // Total Nasabah
        $totalNasabah = User::where('role_id', 1)->get()->count();
        $nasabahTf = Bukti_Tf::latest()->get();
        $nasabahTfPending = Bukti_Tf::where('status_verifikasi', 'pending')->get();
        $totalSaldoTabungan = Bukti_Tf::where('status_verifikasi', 'berhasil')->sum('jumlah_transfer');
        $nasabahPending = Nasabah::with('rekening')
            ->whereHas('rekening', function ($query) {
                $query->where('status_akun', 'non-aktif');
            })->orderByDesc('id')->get();
        $totalPendingRegistrasi = $nasabahPending->count();
        $totalPendingTransfer = $nasabahTfPending->count();
        $totalPending = $totalPendingRegistrasi + $totalPendingTransfer;
        return view('supervisor.dashboard', compact('adminAntarNasabah', 'adminTotal', 'user', 'super', 'nasabahPending', 'nasabahTf', 'nasabahTfPending', 'totalNasabah', 'totalPending', 'totalSaldoTabungan', 'totalPendingRegistrasi', 'totalPendingTransfer'));
    }


    public function verifikasiTFF(Request $request)
    {
        $user = Auth::user();
        $super = $user->petugas;
        $perPage = $request->input('per_page', 10);
        $bukti_tf = Bukti_Tf::latest()->paginate($perPage)
            ->appends(['per_page' => $perPage]);
        return view('supervisor.verifikasi.transfer', compact('bukti_tf', 'user', 'super', 'perPage'));
    }

    public function searchData(Request $request)
    {
        $user = Auth::user();
        $super = $user->petugas;
        $perPage = $request->input('per_page', 10);
        $keyword = $request->keyword;
        $bukti_tf = Bukti_Tf::when($keyword, function ($query, $keyword) {
            return $query->where('nama_penerima', 'LIKE', '%' . $keyword . '%')
                ->orWhere('nama_pengirim', 'like', '%' . $keyword . '%')
                ->orWhere('id_rekening', 'like', '%' . $keyword . '%');
        })->latest()->paginate($perPage)
            ->appends(['per_page' => $perPage]);

        return view('supervisor.verifikasi.transfer', compact('bukti_tf', 'user', 'super', 'keyword','perPage'));
    }

    public function exportExcel(Request $request)
    {
        // Tangkap input filter tanggal dari form
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Kirim tanggal tersebut ke dalam Constructor class BuktiTfExport
        return Excel::download(new BuktiTfExport($startDate, $endDate), 'riwayat-transfer.xlsx');
    }
    // public function exportExcel()
    // {
    // // Mengunduh file dengan nama 'laporan-transfer-supervisor.xlsx'
    // return Excel::download(new BuktiTfExport, 'laporan-transfer-supervisor.xlsx');
    // }

    public function detailTf($id)
    {
        $data = Bukti_Tf::find($id);

        return view('supervisor.verifikasi.transfer.detail', compact('data'));
    }

    public function verifikasiTf(Request $request, $id)
{
    $data = Bukti_Tf::findOrFail($id);

    if ($data->status_verifikasi !== 'pending') {
        return redirect()->back()->with('error', 'Transaksi ini sudah diproses sebelumnya.');
    }

    $request->validate([
        'status_verifikasi' => 'required|in:berhasil,gagal'
    ]);

    try {
        DB::transaction(function () use ($request, $data) {

            if ($request->status_verifikasi === 'berhasil') {
                $rekening = Rekening::where('id', $data->id_rekening)->first();

                if (!$rekening) {
                    throw new \Exception('Nomor rekening tujuan tidak ditemukan.');
                }

                // 1. Tambahkan saldo
                $rekening->increment('saldo_saat_ini', $data->jumlah_transfer);

                // 2. Update status verifikasi
                $data->status_verifikasi = 'berhasil';
                $data->save();

                // 3. PANGGIL SINKRONISASI agar saldo transaksi di history terisi otomatis
                // Pastikan fungsi ini sudah PUBLIC di tellerController.php
                $teller = new \App\Http\Controllers\tellerController();
                $teller->sinkronisasiSaldo($rekening->id);
            } else {
                $data->status_verifikasi = 'gagal';
                $data->save();
            }
        });

        return redirect()->back()->with('success', 'Transaksi berhasil diproses!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal memproses verifikasi: ' . $e->getMessage());
    }
}

    public function verifikasiNasabah(Request $request)
    {
        $user = Auth::user();
        $super = $user->petugas;
        $perPage = $request->input('per_page', 10);
        $allNasabah = Nasabah::with('rekening')
            ->whereHas('rekening', function ($query) {
                $query->where('status_akun', 'non-aktif');
            })->orderByDesc('id')->paginate($perPage)
            ->appends(['per_page' => $perPage]);
        return view('supervisor.verifikasi.registrasirekening', compact('user', 'super', 'allNasabah', 'perPage'));
    }

    public function aktif(String $id)
    {
        $rekening = Rekening::FindOrFail($id);

        $rekening->status_akun = 'aktif';

        $rekening->save();

        //  Ubah nama route di bawah ini agar sesuai dengan web.php kamu
        return redirect()->route('supervisor.verifikasi.registrasi')->with('success', 'Rekening Telah Aktif');
    }


    public function destroy(String $id)
    {
        $nasabah = Nasabah::FindOrFail($id);
        $user = User::where('id', $nasabah->user_id)->first();
        $rekening = Rekening::where('nasabah_id', $nasabah->id)->first();

        $rekening->delete();
        $nasabah->delete();
        $user->delete();


        return redirect()->route('verifikasi.rekening')->with('success', 'data nasabah berhasil di hapus');
    }

    public function detail(String $id)
    {
        $user = Auth::user();
        $nasabah = Nasabah::with('rekening', 'jurusan', 'provinsi', 'kabupaten', 'kecamatan', 'desa')->findOrFail($id);
        return view('supervisor.verifikasi.registrasirekening.detail', compact('user', 'nasabah'));
    }

    public function datapetugas()
    {
        $user = Auth::user();
        $super = $user->petugas;
        return view('supervisor.datapetugas', compact('user', 'super'));
    }

    public function nasabah(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->input('per_page', 10);

        $userNasabah = Nasabah::with('rekening')->orderByDesc('id')
            ->paginate($perPage)
            ->appends(['per_page' => $perPage]);
        return view('supervisor.datanasabah', compact('userNasabah', 'user', 'perPage',));
    }

    public function detailNasabah(String $id)
    {
        $user = Auth::user();
        $nasabah = Nasabah::with('rekening', 'jurusan', 'provinsi', 'kabupaten', 'kecamatan', 'desa')->findOrFail($id);
        return view('supervisor.crud_datanasabah.detail', compact('user', 'nasabah'));
    }

    public function revisi(String $id, Request $request)
    {
        $request->validate([
            'pesan' => 'required',
            'nama_perevisi' => 'required',
            'status_akun' => 'required',
        ]);



        $nasabah = Nasabah::FindOrFAil($id);
        $nasabah->update([
            'pesan' => $request->pesan,
            'nama_perevisi' => $request->nama_perevisi,
        ]);

        $rekening = Rekening::where('nasabah_id', $nasabah->id);
        $rekening->update([
            'status_akun' => $request->status_akun,
        ]);

        return redirect()->route('verifikasi.rekening')->with('success', 'data revisi berhasil di kirim');
    }

    public function halamanRevisi(String $id)
    {
        $user = Auth::user();
        $nasabah = Nasabah::FindOrFail($id);
        $rekening = Rekening::where('nasabah_id', $nasabah->id);
        return view('supervisor.verifikasi.registrasirekening.revisi', compact('nasabah', 'rekening', 'user'));
    }

    public function verifikasiLogin(Request $request)
    {
        $user = Auth::user();

        $perPage = $request->input('per_page', 10);

        $data = VerifikasiLogin::with(['user'])
            ->latest()
            ->paginate($perPage)
            ->appends(['per_page' => $perPage]);

        return view(
            'supervisor.verifikasi.login',
            compact('user', 'data', 'perPage')
        );
    }
    public function setujuiLogin($id)
    {
        VerifikasiLogin::findOrFail($id)
            ->update([
                'status' => 'disetujui',
                'supervisor_id' => Auth::id(),
                'waktu_verifikasi' => Carbon::now()
            ]);

        return back()->with('success', 'Login disetujui');
    }

    public function tolakLogin($id)
    {
        VerifikasiLogin::findOrFail($id)
            ->update([
                'status' => 'ditolak',
                'supervisor_id' => Auth::id(),
                'waktu_verifikasi' => Carbon::now()
            ]);

        return back()->with('success', 'Login ditolak');
    }

    public function destroyAllLogin()
    {
        VerifikasiLogin::truncate(); // atau ::query()->delete(); jika ada constraint foreign key

        return redirect()->back()->with('success', 'Semua data verifikasi login berhasil dihapus.');
    }

    // Fungsi untuk menampilkan halaman biaya transaksi
    public function biayatransaksi()
    {
        $user = Auth::user();
        $super = $user->petugas;

        $setoran = Transaksi::where('jenis_transaksi', 'Setoran')->first();
        $penarikan = Transaksi::where('jenis_transaksi', 'Penarikan')->first();
        $transfer = Transaksi::where('jenis_transaksi', 'Transfer')->first();
        $transfer_luar = Transaksi::where('jenis_transaksi', 'Transfer_Luar')->first();
        $transfer_nasabah = Transaksi::where('jenis_transaksi', 'Transfer_Nasabah')->first();

        return view(
            'supervisor.biayatransaksi',
            compact(
                'user',
                'super',
                'setoran',
                'penarikan',
                'transfer',
                'transfer_luar',
                'transfer_nasabah'
            )
        );
    }

    public function updateBiayaTransaksi(Request $request)
    {
        Transaksi::where(
            'jenis_transaksi',
            'Setoran'
        )->update([
            'nominal' => $request->biaya_setoran
        ]);

        Transaksi::where(
            'jenis_transaksi',
            'Penarikan'
        )->update([
            'nominal' => $request->biaya_penarikan
        ]);

        Transaksi::where(
            'jenis_transaksi',
            'Transfer'
        )->update([
            'nominal' => $request->biaya_transfer
        ]);

        Transaksi::where(
            'jenis_transaksi',
            'Transfer_Luar'
        )->update([
            'nominal' => $request->biaya_transfer_luar
        ]);

        Transaksi::where(
            'jenis_transaksi',
            'Transfer_Nasabah'
        )->update([
            'nominal' => $request->biaya_transfer_nasabah
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function saldoMinimum()
    {
        $user = Auth::user();
        $super = $user->petugas;


        $saldoMinimum = Minimum_saldo::where('jenis_minimum', 'penarikan')->first();
        return view('supervisor.saldominimum', compact('user', 'super', 'saldoMinimum'));
    }

    public function saldoMinimumUpdate(Request $request)
    {
        // 1. Validasi data yang masuk
        $request->validate([
            'minimum_saldo' => 'required|numeric',
        ]);

        $saldo = Minimum_saldo::first();
        $saldo->nominal = $request->minimum_saldo;
        $saldo->save();

        // 3. WAJIB: Kembalikan respons berupa JSON sukses
        return response()->json([
            'success' => true,
            'message' => 'Biaya transaksi berhasil disimpan!'
        ]);
    }

    public function print(String $id)
    {
        $nasabah = Nasabah::with('rekening')->FindOrFail($id);

        return view('supervisor.crud_datanasabah.print', compact('nasabah'));
    }
}
