<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{

    protected $table = 'rekening';

    protected $primaryKey = 'id';

    // karena id diisi manual
    public $incrementing = false;

    // tipe id
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'nasabah_id',
        'saldo_saat_ini',
        'status_akun'
    ];

    // relasi ke tabel nasabah
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }
}
