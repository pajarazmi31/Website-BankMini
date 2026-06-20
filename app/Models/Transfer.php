<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $table = 'transfer';

    // Disable default timestamps jika kamu tidak pakai created_at/updated_at,
    // tapi karena di migration kita tambahkan $table->timestamps(), kita biarkan true.
    
    protected $fillable = [
        'id_rekening_pengirim',
        'id_rekening_penerima',
        'jumlah_transfer',
        'transaksi_id',
        'total_biaya',
        'datetime',
        'catatan',
        'id_petugas',
    ];

    /**
     * Relasi rekening pengirim
     */
    public function rekeningPengirim()
    {
        return $this->belongsTo(
            Rekening::class,
            'id_rekening_pengirim',
            'id'
        );
    }

    /**
     * Relasi rekening penerima
     */
    public function rekeningPenerima()
    {
        return $this->belongsTo(
            Rekening::class,
            'id_rekening_penerima',
            'id'
        );
    }

    /**
     * Relasi petugas
     */
    public function petugas() {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id');
    }

    /**
     * Relasi ke Master Transaksi (Jenis transaksi & Nominal Biaya Admin)
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'id');
    }
}