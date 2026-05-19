<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
    protected $table = 'setoran';

    protected $fillable = [
        'id_rekening',
        'id_petugas',
        'mata_uang',
        'uang_terbilang',
        'catatan',
        'jumlah_penyetoran',
        'setoran',
        'biaya_transaksi',
        'nama_lengkap',
        'nama_penyetor',
        'alamat_penyetor',
        'no_hp_penyetor',
        'total_biaya',
        'datetime_tgl'
    ];

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'id_rekening', 'id');
    }
}