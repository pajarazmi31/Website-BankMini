<?php

namespace App\Models;
use App\Models\Rekening;
use App\Models\Jurusan;
use App\Models\Desa;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Provinsi;

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
        'jurusan_id',
        'jenis_kelamin',
        'pendidikan',
        'alamat',
        'kelurahan_id',
        'kecamatan_id',
        'kab_kota_id',
        'provinsi_id',
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
        'hubungan_kontak_darurat',
        'pesan',
        'nama_perevisi'
    ]);

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function rekening() {
        return $this->HasOne(Rekening::class);
    }

    public function jurusan() {
        return $this->belongsTo(Jurusan::class);
    }

        public function provinsi()
        {
            return $this->belongsTo(Provinsi::class);
        }

        public function kabupaten()
        {
            return $this->belongsTo(Kabupaten::class, 'kab_kota_id');
        }

        public function kecamatan()
        {
            return $this->belongsTo(Kecamatan::class);
        }

        public function desa()
        {
            return $this->belongsTo(Desa::class, 'kelurahan_id');
        }

}
