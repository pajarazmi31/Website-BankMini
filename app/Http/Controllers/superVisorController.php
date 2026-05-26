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
        $nasabah = Nasabah::with('rekening')
        ->whereHas('rekening', function ($query) {
            $query->where('status_akun', 'non-aktif');
        })
        ->get();
        return view('supervisor.dashboard', compact('user','super','nasabah'));
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

    public function detail(String $id) {
        $nasabah = Nasabah::with('rekening', 'jurusan', 'provinsi', 'kabupaten', 'kecamatan', 'desa')->findOrFail($id);
        return view('supervisor.verifikasi.registrasirekening.detail', compact('nasabah'));
    }

    public function datapetugas(){
        $user = Auth::user();
        return view('supervisor.datapetugas', compact( 'user'));
    }

    public function nasabah() {
        $userNasabah = Nasabah::with('rekening')->get();
        $user = Auth::user();
        return view('supervisor.datanasabah', compact('userNasabah', 'user'));
    }

    public function detailNasabah(String $id) {
        $nasabah = Nasabah::with('rekening', 'jurusan', 'provinsi', 'kabupaten', 'kecamatan', 'desa')->findOrFail($id);
        return view('supervisor.crud_datanasabah.detail', compact('nasabah'));
    }

    public function revisi(String $id, Request $request) {
        $request->validate([
            'pesan' => 'required',
            'status_akun' => 'required',
        ]);

        $nasabah = Nasabah::FindOrFAil($id);
        $nasabah->update([
            'pesan' => $request->pesan,
        ]);

        $rekening = Rekening::where('nasabah_id', $nasabah->id);
        $rekening->update([
            'status_akun' => $request->status_akun,
        ]);

        return redirect()->route('verifikasi.rekening')->with('success','data revisi berhasil di kirim');
    }

    public function halamanRevisi(String $id) {
        $nasabah = Nasabah::FindOrFail($id);
        $rekening = Rekening::where('nasabah_id', $nasabah->id);
        return view('supervisor.verifikasi.registrasirekening.revisi', compact('nasabah','rekening'));
    }
}
