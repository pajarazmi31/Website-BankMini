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
        'transaksi_id',
        'nama_lengkap',
        'nama_penyetor',
        'alamat_penyetor',
        'no_hp_penyetor',
        'total_biaya',
        'pilihan_biaya_transaksi',
        'nominal_admin'
    ];

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'id_rekening', 'id');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
    
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas');
    }
}