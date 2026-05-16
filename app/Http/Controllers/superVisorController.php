<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Bukti_Tf;

class superVisorController extends Controller
{
    public function index() {
        $user = Auth::user();
        $super = $user->petugas;
        return view('supervisor.dashboard', compact('user','super'));
    }

    public function verifikasi(){
        $bukti_tf = Bukti_Tf::all();
        return view('supervisor.verifikasi.transfer', compact('bukti_tf'));
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
}
