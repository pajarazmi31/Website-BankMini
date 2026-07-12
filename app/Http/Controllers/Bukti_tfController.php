<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bukti_Tf;
use App\Models\Rekening;

class Bukti_tfController extends Controller
{
    public function cekRekening($id)
    {
        // Cari ke tabel rekening berdasarkan NOMOR REKENING-nya (kolom 'id' di tabel rekening kamu)
        // Gunakan ->where() agar pencarian string nomor rekening akurat
        $rekening = Rekening::with('nasabah')->where('id', $id)->first();

        if ($rekening && $rekening->nasabah) {
            return response()->json([
                'success' => true,
                'nama' => $rekening->nasabah->nama_nasabah
            ]);
        }

        return response()->json([
            'success' => false,
            'pesan' => 'Rekening tidak ditemukan'
        ]);
    }

    public function transfer_luar(Request $request){
    if ($request->has('jumlah_transfer')) {
        $cleanValue = str_replace('.', '', $request->jumlah_transfer);
        $request->merge(['jumlah_transfer' => $cleanValue]);
    }

    $request->validate([
        'nama_pengirim' => 'required',
        'no_hp_pengirim' => 'required',
        'id_rekening' => 'required|exists:rekening,id',
        'jumlah_transfer' => 'required|numeric|min:500',
        'bukti_foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'nama_penerima' => 'required',
        'datetime_tgl' => 'required',
        'catatan' => 'nullable',
        ], [
        // Tulis pesan kustom kamu di sini:
        'id_rekening.exists' => 'Maaf, nomor rekening tidak terdaftar di sistem kami.',
        'id_rekening.required' => 'Nomor rekening wajib diisi.',
    ]);

           $file = $request->file('bukti_foto');

$namaFile = time().'_'.$file->getClientOriginalName();

$tujuan = public_path('uploads');

$file->move($tujuan, $namaFile);

$buktiPath = 'uploads/'.$namaFile;

Bukti_Tf::create([
    'nama_pengirim' => $request->nama_pengirim,
    'no_hp_pengirim' => $request->no_hp_pengirim,
    'id_rekening' => $request->id_rekening,
    'jumlah_transfer' => $request->jumlah_transfer,
    'bukti_foto' => $buktiPath,
    'nama_penerima' => $request->nama_penerima,
    'status_verifikasi' => 'pending',
    'datetime_tgl' => $request->datetime_tgl,
    'catatan' => $request->catatan
]);

return redirect()->back()->with('success', 'Data berhasil ditambahkan.');

    }   // <-- tutup function transfer_luar

}       // <-- tutup class Bukti_tfController