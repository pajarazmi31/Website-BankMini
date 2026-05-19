<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Rekening;
use App\Models\Setoran;
use App\Models\Penarikan;

class tellerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $teller = $user->petugas;

        return view('teller.dashboard', compact('user', 'teller'));
    }

        public function transfer()
    {
        $user = Auth::user();
        $teller = $user->petugas;

        return view('teller.transfer', compact('user', 'teller'));
    }

    public function penarikan()
    {
        $user = Auth::user();

        $teller = $user->petugas;

        $data = Penarikan::latest()->get();

        return view(
            'teller.penarikan',
            compact(
                'user',
                'teller',
                'data'
            )
        );
    }

    public function setoran()
    {
        $user = Auth::user();
        $teller = $user->petugas;

        // ambil data setoran terbaru
        $data = Setoran::latest()->get();

        return view('teller.setoran', compact(
            'user',
            'teller',
            'data'
        ));
    }

    public function storeSetoran(Request $request)
    {
        $request->validate([
            'id_rekening' => 'required|exists:rekening,id',
            'jumlah_penyetoran' => 'required|numeric|min:1',
            'setoran' => 'required',
            'nama_penyetor' => 'required'
        ]);

        // cari rekening
        $rekening = Rekening::find($request->id_rekening);

        if (!$rekening) {
            return back()->with('error', 'Rekening tidak ditemukan');
        }

        // biaya transaksi
        $biaya = $request->biaya_transaksi ?? 0;

        // total saldo masuk
        $totalBiaya = $request->jumlah_penyetoran - $biaya;

        // simpan setoran
        Setoran::create([
            'id_rekening' => $request->id_rekening,
            'id_petugas' => Auth::id(),

            'mata_uang' => $request->mata_uang,
            'uang_terbilang' => $request->uang_terbilang,
            'catatan' => $request->catatan,

            'jumlah_penyetoran' => $request->jumlah_penyetoran,

            'setoran' => $request->setoran,

            'biaya_transaksi' => $biaya,

            'nama_lengkap' => $request->nama_lengkap,
            'nama_penyetor' => $request->nama_penyetor,
            'alamat_penyetor' => $request->alamat_penyetor,
            'no_hp_penyetor' => $request->no_hp_penyetor,

            'total_biaya' => $totalBiaya,

            'datetime_tgl' => now(),
        ]);

        // update saldo rekening
        $rekening->saldo_saat_ini += $totalBiaya;

        $rekening->save();

        return back()->with('success', 'Penyetoran berhasil');
    }


        public function updateSetoran(Request $request, $id)
    {
        $setoran = Setoran::findOrFail($id);

        $rekening = Rekening::find(
            $setoran->id_rekening
        );

        // rollback saldo lama
        $rekening->saldo_saat_ini -=
            $setoran->jumlah_penyetoran;

        // hitung saldo baru
        $biaya = $request->biaya_transaksi ?? 0;

        $totalBiaya =
            $request->jumlah_penyetoran - $biaya;

        // masukin nominal baru
        $rekening->saldo_saat_ini +=
            $totalBiaya;

        $rekening->save();

        // update data setoran
        $setoran->update([

            'nama_lengkap' =>
                $request->nama_lengkap,

            'id_rekening' =>
                $request->id_rekening,

            'jumlah_penyetoran' =>
                $request->jumlah_penyetoran,

            'setoran' =>
                $request->setoran,

            'mata_uang' =>
                $request->mata_uang,

            'uang_terbilang' =>
                $request->uang_terbilang,

            'nama_penyetor' =>
                $request->nama_penyetor,

            'no_hp_penyetor' =>
                $request->no_hp_penyetor,

            'alamat_penyetor' =>
                $request->alamat_penyetor,

            'biaya_transaksi' =>
                $biaya,

            'total_biaya' =>
                $totalBiaya,

            'catatan' =>
                $request->catatan,
        ]);

        return back()->with(
            'success',
            'Data berhasil diupdate'
        );
    }

    public function destroySetoran($id)
    {
        $setoran = Setoran::findOrFail($id);

        $setoran->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }


        //logic penarikan na
            public function storePenarikan(Request $request)
        {
            $request->validate([
                'id_rekening' => 'required|exists:rekening,id',
                'jumlah_penarikan' => 'required|numeric|min:1',
                'nama_penarik' => 'required'
            ]);

            // cari rekening
            $rekening = Rekening::find($request->id_rekening);

            if (!$rekening) {
                return back()->with(
                    'error',
                    'Rekening tidak ditemukan'
                );
            }

            // cek saldo cukup atau tidak
            if (
                $rekening->saldo_saat_ini
                < $request->jumlah_penarikan
            ) {
                return back()->with(
                    'error',
                    'Saldo tidak mencukupi'
                );
            }

            // kurangi saldo rekening
            $rekening->saldo_saat_ini -=
                $request->jumlah_penarikan;

            $rekening->save();

            // simpan data penarikan
            Penarikan::create([

                'id_rekening' => $request->id_rekening,

                'id_petugas' => Auth::id(),

                'nama_penarik' => $request->nama_penarik,

                'jumlah_penarikan' =>
                    $request->jumlah_penarikan,

            ]);

            return back()->with(
                'success',
                'Penarikan berhasil'
            );
        }


        //logika update na
            public function updatePenarikan(Request $request, $id)
        {
            $penarikan = Penarikan::findOrFail($id);

            // cari rekening
            $rekening = Rekening::find(
                $penarikan->id_rekening
            );

            // balikin saldo lama dulu
            $rekening->saldo_saat_ini +=
                $penarikan->jumlah_penarikan;

            // cek saldo cukup setelah edit
            if (
                $rekening->saldo_saat_ini
                < $request->jumlah_penarikan
            ) {
                return back()->with(
                    'error',
                    'Saldo tidak mencukupi'
                );
            }

            // kurangi saldo baru
            $rekening->saldo_saat_ini -=
                $request->jumlah_penarikan;

            $rekening->save();

            // update data
            $penarikan->update([

                'nama_penarik' =>
                    $request->nama_penarik,

                'id_rekening' =>
                    $request->id_rekening,

                'jumlah_penarikan' =>
                    $request->jumlah_penarikan,
            ]);

            return back()->with(
                'success',
                'Data penarikan berhasil diupdate'
            );
        }


        public function destroyPenarikan($id)
        {
            $penarikan = Penarikan::findOrFail($id);

            $penarikan->delete();

            return back()->with(
                'success',
                'History penarikan berhasil dihapus'
            );
        }
}