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
        'transaksi_id',
        'biaya_transaksi', // Kita tambahkan ini bray agar bisa disimpan ke db
        'total_biaya',
        'datetime_tgl'
    ];

    /**
     * Relasi ke Petugas yang memproses penarikan
     */
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id');
    }

    /**
     * Relasi ke Transaksi Utama
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'id');
    }
}