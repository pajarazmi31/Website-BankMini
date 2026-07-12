<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifikasiLogin extends Model
{
    protected $table = 'verifikasi_login';

    protected $fillable = [
        'user_id',
        'status',
        'supervisor_id',
        'waktu_verifikasi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}