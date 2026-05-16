<?php

namespace App\Models;
use App\Models\Rekening;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    protected $table = 'nasabah';

    protected $fillable = ([
        'nis_nip',
        'nama_nasabah',
        'user_id',
        'tempat_lahir',
        'tanggal_lahir',
        'jurusan',
        'jenis_kelamin',
        'pendidikan',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kab_kota',
        'provinsi',
        'kode_pos',
        'email',
        'agama',
        'no_hp',
        'password',
        'jabatan',
        'jenis_identitas',
        'nama_kontak_darurat',
        'alamat_kontak_darurat',
        'no_hp_kontak_darurat',
        'hubungan_kontak_darurat'
    ]);

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function rekening() {
        return $this->HasOne(Rekening::class);
    }
}
