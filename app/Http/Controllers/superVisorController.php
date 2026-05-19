<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Bukti_Tf;
use App\Models\User;

class superVisorController extends Controller
{
    public function index() {
        $user = Auth::user();
        $super = $user->petugas;

        // Total Nasabah
        $nasabahTf = Bukti_Tf::all();
        $nasabahTfPending = Bukti_Tf::where('status_verifikasi', 'pending')->get();
        $totalNasabah = User::where('role_id', 1)->get()->count();

        $totalPending = Bukti_Tf::where('status_verifikasi', 'pending')->count();
        return view('supervisor.dashboard', compact('user','super', 'nasabahTf', 'nasabahTfPending','totalNasabah', 'totalPending'));
    }

    public function verifikasi(){
        $user = Auth::user();
        $super = $user->petugas;
        $bukti_tf = Bukti_Tf::all();
        return view('supervisor.verifikasi.transfer', compact('bukti_tf', 'user', 'super'));
    }

    public function detail($id){
        $data = Bukti_Tf::find($id);

        return view('supervisor.verifikasi.transfer.detail', compact('data'));
    }

    public function verifikasiTf(Request $request, $id){
            $data = Bukti_Tf::findOrFail($id);

            // LOGIKA KUNCI: Cek apakah status sudah pernah diproses
            if ($data->status_verifikasi !== 'pending') {
                return redirect()->back()->with('error', 'Transaksi ini sudah diproses sebelumnya dan tidak bisa diubah lagi.');
            }

            // Jika masih pending, maka lanjutkan update
            $data->update([
                'status_verifikasi' => $request->status_verifikasi // 'disetujui' atau 'tolak'
            ]);

            return redirect()->back()->with('success', 'Status berhasil diperbarui!');
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
