<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusan';

    protected $fillable = ([
        'jurusan',
        'singkatan',
    ]);
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
