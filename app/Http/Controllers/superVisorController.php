<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Nasabah;
use App\Models\Rekening;
use App\Models\Petugas;

class superVisorController extends Controller
{
    public function index() {
        $user = Auth::user();
        $super = $user->petugas;
        return view('supervisor.dashboard', compact('user','super'));
    }

    public function verifikasi() {
        $user = Auth::user();
        $super = $user->petugas;
        $allNasabah = Nasabah::with('rekening')
            ->whereHas('rekening', function ($query) {
                $query->where('status_akun', 'non-aktif');
            })
            ->get();
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
}
