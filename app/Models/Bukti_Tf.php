<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bukti_Tf extends Model
{
    protected $table = 'bukti_tf';

    protected $fillable = ([
        'nama_pengirim',
        'no_hp_pengirim',
        'id_rekening',
        'no_rekening_penerima',
        'nominal_admin',
        'jumlah_transfer',
        'bukti_foto',
        'nama_penerima',
        'status_verifikasi',
        'datetime_tgl',
        'catatan',
        'transaksi_id',
    ]);

    public function buktiTf()
    {
        return $this->belongsTo(Rekening::class, 'id_rekening', 'id');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'id');
    }
}
