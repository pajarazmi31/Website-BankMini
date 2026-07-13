<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Minimum_saldo extends Model
{
       protected $table = 'minimum_saldo';

       protected $fillable = [
        'jenis_minimum',
        'nominal'
       ];
}
