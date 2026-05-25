<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    protected $table = 'rekening';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nasabah_id',
        'saldo_saat_ini',
        'status_akun'
    ];

    public function setoran()
    {
        return $this->hasMany(Setoran::class, 'id_rekening', 'id');
    }

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class, 'nasabah_id');
    }
}