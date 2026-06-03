<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class alamatController extends Controller
{
    public function getKabupaten( String $id)
    {
        $kabupaten = DB::table('kabupaten')
            ->where('provinsi_id', $id)
            ->get();

        return response()->json($kabupaten);
    }

    public function getKecamatan( String $id ) {
        $kecamatan = DB::table('kecamatan')
        ->where('kabupaten_id', $id)
        ->get();

        return response()->json($kecamatan);
    }

    public function getDesa( String $id ) {
        $desa = DB::table('desa')
        ->where('kecamatan_id', $id)
        ->get();

        return response()->json($desa);
    }
}
