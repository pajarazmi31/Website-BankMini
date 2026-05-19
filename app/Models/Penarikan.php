<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penarikan extends Model
{
        protected $table = 'penarikan';

    protected $fillable = [
        'id_rekening',
        'id_petugas',
        'nama_penarik',
        'jumlah_penarikan',
        'datetime_tgl'
    ];
}
