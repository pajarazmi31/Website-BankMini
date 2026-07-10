<?php

namespace App\Http\Controllers;
use App\Models\data_siswa;

use Illuminate\Http\Request;

class siswaController extends Controller
{
    public function getSiswa($nis)
    {
        $siswa = data_siswa::where('nis', $nis)->first();

        if (!$siswa) {
            return response()->json([
                'status' => false
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $siswa
        ]);
    }
}
