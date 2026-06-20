<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatTf extends Model
{
    protected $table = 'riwayat_tf';

    protected $fillable = [
        'id_pengirim',
        'id_penerima',
        'nama_penerima', // Sebenarnya ini opsional jika sudah berelasi ke Rekening, tapi tidak apa-apa jika ingin disimpan
        'jumlah_transfer',
        'catatan'
    ];

    // Relasi ke rekening penerima
    public function penerima()
    {
        return $this->belongsTo(Rekening::class, 'id_penerima', 'id');
    }

    // Relasi ke rekening pengirim (Tambahan agar data lengkap)
    public function pengirim()
    {
        return $this->belongsTo(Rekening::class, 'id_pengirim', 'id');
    }
}