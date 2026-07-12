<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'jenis_transaksi',
        'nominal'
    ];

    // ======================================================
    // ================== RELASI HAS MANY ===================
    // ======================================================

    public function setoran()
    {
        // Sesuaikan dengan nama kolom foreign key di tabel setoran lu nanti, bray
        return $this->hasMany(Setoran::class, 'transaksi_id', 'id');
    }

    public function penarikan()
    {
        // Di tabel penarikan kemarin pake transaksi_id juga kan?
        return $this->hasMany(Penarikan::class, 'transaksi_id', 'id');
    }

    /**
     * Relasi ke tabel transfer yang bener, mengarah ke kolom 'transaksi_id'
     */
    public function transfer()
    {
        return $this->hasMany(Transfer::class, 'transaksi_id', 'id');
    }

    public function transfer_luar()
    {
        return $this->hasMany(Bukti_Tf::class, 'transaksi_id', 'id');
    }

    public function transfer_nasabah()
    {
        return $this->hasMany(RiwayatTf::class, 'transaksi_id', 'id');
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'transaksi_id', 'id');
    }

    public function buktiTf()
    {
        return $this->hasMany(Bukti_Tf::class, 'id_rekening', 'id');
    }

    public function RiwayatTf()
    {
        return $this->hasMany(Bukti_Tf::class, 'id_rekening', 'id');
    }
}