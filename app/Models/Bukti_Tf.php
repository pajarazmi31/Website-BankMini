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
        'jumlah_transfer',
        'bukti_foto',
        'nama_penerima',
        'status_verifikasi',
        'datetime_tgl',
        'catatan',
    ]);

    public function buktiTf()
    {
        return $this->belongsTo(Rekening::class, 'id_rekening', 'id');
    }
}
