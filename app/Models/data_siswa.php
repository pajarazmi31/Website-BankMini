<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class data_siswa extends Model
{
    protected $table = 'data_siswa';
    protected $primaryKey = 'nis';
    public $timestamps = false;
}
