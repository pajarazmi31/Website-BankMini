<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bukti_Tf;

class Bukti_tfController extends Controller
{
    public function transfer_luar(Request $request){
    $request->validate([
        'nama_pengirim' => 'required',
        'no_hp_pengirim' => 'required',
        'no_rekening_penerima' => 'required',
        'jumlah_transfer' => 'required',
        'bukti_foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'nama_penerima' => 'required',
        'datetime_tgl' => 'required',
        'catatan' => 'required',
    ]);

     $buktiPath = $request->file('bukti_foto')->store('bukti_fotos', 'public');

    Bukti_Tf::create([
        'nama_pengirim' => $request->nama_pengirim,
        'no_hp_pengirim' => $request->no_hp_pengirim,
        'no_rekening_penerima' => $request->no_rekening_penerima,
        'jumlah_transfer' => $request->jumlah_transfer,
        'bukti_foto' => $buktiPath,
        'nama_penerima' => $request->nama_penerima,
        'status_verifikasi' => 'pending',
        'datetime_tgl' => $request->datetime_tgl,
        'catatan' => $request->catatan
    ]);

    return redirect()->back()->with('succsses', 'data berhasil ditambahkan');
    }
}
