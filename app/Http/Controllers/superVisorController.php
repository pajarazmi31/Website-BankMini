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

        $totalPending = Bukti_Tf::where('status_verifikasi', 'pending')->count();
        return view('supervisor.dashboard', compact('user','super', 'nasabahTf', 'nasabahTfPending','totalNasabah', 'totalPending','totalSaldoTabungan'));
    }

    
    public function verifikasi(){
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
                                ->orWhere('id_rekening', 'like', '%' . $keyword .'%');;
        })->get();

        return view('supervisor.verifikasi.transfer', compact('bukti_tf', 'user', 'super', 'keyword'));
    }

    public function exportExcel() 
    {
    // Mengunduh file dengan nama 'laporan-transfer-supervisor.xlsx'
    return Excel::download(new BuktiTfExport, 'laporan-transfer-supervisor.xlsx');
    }

    public function detail($id){
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

    public function registrasiRekening(){
        $user = Auth::user();
        $super = $user->petugas;

        return view('supervisor.verifikasi.registrasirekening', compact('user' ,'super'));
    }

        public function dataPetugas(){
        $user = Auth::user();
        $super = $user->petugas;

        return view('supervisor.datapetugas', compact('user' ,'super'));
    }

        public function dataNasabah(){
        $user = Auth::user();
        $super = $user->petugas;

        return view('supervisor.datanasabah', compact('user' ,'super'));
    }

}
