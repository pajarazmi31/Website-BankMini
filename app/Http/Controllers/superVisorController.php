<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Bukti_Tf;
use App\Models\Rekening;
use app\Exports\BuktiTfExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Nasabah;
use App\Models\Petugas;


class superVisorController extends Controller
{
    public function index() {
        $user = Auth::user();
        $super = $user->petugas;

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
        return view('supervisor.dashboard', compact('user','super', 'nasabahPending', 'nasabahTf', 'nasabahTfPending','totalNasabah', 'totalPending','totalSaldoTabungan','totalPendingRegistrasi','totalPendingTransfer'));
    }


    public function verifikasiTFF(){
        $user = Auth::user();
        $super = $user->petugas;
        $bukti_tf = Bukti_Tf::latest()->get();
        return view('supervisor.verifikasi.transfer', compact('bukti_tf', 'user', 'super'));
        }

    public function searchData(Request $request){
        $user = Auth::user();
        $super = $user->petugas;
        $keyword = $request->keyword;
        $bukti_tf = Bukti_Tf::when($keyword, function ($query, $keyword) {
            return $query->where('nama_penerima', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('nama_pengirim', 'like', '%' . $keyword .'%')
                                ->orWhere('id_rekening', 'like', '%' . $keyword .'%');
        })->get();

        return view('supervisor.verifikasi.transfer', compact('bukti_tf', 'user', 'super', 'keyword'));
    }

    public function exportExcel()
    {
    // Mengunduh file dengan nama 'laporan-transfer-supervisor.xlsx'
    return Excel::download(new BuktiTfExport, 'laporan-transfer-supervisor.xlsx');
    }

    public function detailTf($id){
        $data = Bukti_Tf::find($id);

        return view('supervisor.verifikasi.transfer.detail', compact('data'));
    }

    public function verifikasiTf(Request $request, $id)
    {
        // 1. Cari data bukti transfer berdasarkan ID-nya
        $data = Bukti_Tf::findOrFail($id);

        // 2. Kunci Status: Jika sudah 'berhasil' atau 'gagal', jangan diproses lagi
        if ($data->status_verifikasi !== 'pending') {
            return redirect()->back()->with('error', 'Transaksi ini sudah diproses sebelumnya.');
        }

        // 3. Validasi input tombol (berhasil/gagal)
        $request->validate([
            'status_verifikasi' => 'required|in:berhasil,gagal'
        ]);

        try {
            // Jalankan Database Transaction untuk keamanan mutasi saldo
            DB::transaction(function () use ($request, $data) {

                if ($request->status_verifikasi === 'berhasil') {

                    // MENCARI REKENING:
                    // Kita tembak kolom 'id' di tabel rekening menggunakan nilai yang tersimpan
                    // di kolom 'no_rekening_penerima' pada tabel Bukti_Tf.
                    $rekening = Rekening::where('id', $data->id_rekening)->first();

                    if (!$rekening) {
                        throw new \Exception('Nomor rekening tujuan (' . $data->id_rekening . ') tidak ditemukan di sistem.');
                    }

                    // Tambahkan saldo ke kolom 'saldo_saat_ini' di tabel rekening
                    $rekening->increment('saldo_saat_ini', $data->jumlah_transfer);
                }

                // 4. Update status verifikasi transaksi menjadi 'berhasil' atau 'gagal'
                $data->status_verifikasi = $request->status_verifikasi;
                $data->save();
            });

            $pesan = $request->status_verifikasi === 'berhasil'
                ? 'Transaksi berhasil disetujui, saldo masuk ke rekening tujuan!'
                : 'Transaksi telah ditolak.';

            return redirect()->back()->with('success', $pesan);

        } catch (\Exception $e) {
            // Jika ada eror di dalam blok DB::transaction, saldo batal bertambah
            return redirect()->back()->with('error', 'Gagal memproses verifikasi: ' . $e->getMessage());
        }
    }

    public function verifikasiNasabah() {
        $user = Auth::user();
        $super = $user->petugas;
        $allNasabah = Nasabah::with('rekening')
            ->whereHas('rekening', function ($query) {
                $query->where('status_akun', 'non-aktif');
            })->orderByDesc('id')->get();
        return view('supervisor.verifikasi.registrasirekening', compact('user','super','allNasabah'));
    }

    public function aktif(String $id) {
        $rekening = Rekening::FindOrFail($id);

        $rekening->status_akun = 'aktif';

        $rekening->save();

        return redirect()->route('verifikasi.rekening')->with('success','Rekening Telah Aktif');
    }


    public function destroy(String $id) {
        $nasabah = Nasabah::FindOrFail($id);
        $user = User::where('id', $nasabah->user_id)->first();
        $rekening = Rekening::where('nasabah_id', $nasabah->id)->first();

        $rekening->delete();
        $nasabah->delete();
        $user->delete();


        return redirect()->route('verifikasi.rekening')->with('success','data nasabah berhasil di hapus');
    }

    public function detail(String $id) {
        $user = Auth::user();
        $nasabah = Nasabah::with('rekening', 'jurusan', 'provinsi', 'kabupaten', 'kecamatan', 'desa')->findOrFail($id);
        return view('supervisor.verifikasi.registrasirekening.detail', compact('user','nasabah'));
    }

    public function datapetugas(){
        $user = Auth::user();
        $super = $user->petugas;
        return view('supervisor.datapetugas', compact( 'user','super'));
    }

    public function nasabah() {
        $userNasabah = Nasabah::with('rekening')->orderByDesc('id')->get();
        $user = Auth::user();
        return view('supervisor.datanasabah', compact('userNasabah', 'user'));
    }

    public function detailNasabah(String $id) {
        $user = Auth::user();
        $nasabah = Nasabah::with('rekening', 'jurusan', 'provinsi', 'kabupaten', 'kecamatan', 'desa')->findOrFail($id);
        return view('supervisor.crud_datanasabah.detail', compact('user','nasabah'));
    }

    public function revisi(String $id, Request $request) {
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

        return redirect()->route('verifikasi.rekening')->with('success','data revisi berhasil di kirim');
    }

    public function halamanRevisi(String $id) {
        $user = Auth::user();
        $nasabah = Nasabah::FindOrFail($id);
        $rekening = Rekening::where('nasabah_id', $nasabah->id);
        return view('supervisor.verifikasi.registrasirekening.revisi', compact('nasabah','rekening', 'user'));
    }


}
