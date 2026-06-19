<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Nasabah;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class NasabahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roleNasabah = Role::where('nama_role', 'nasabah')->first();

        $userNasabah = User::create([
            'name' => 'Dinar',
            'role_id' => $roleNasabah->id,
            'email' => 'dinar@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        Nasabah::create([
            'user_id' => $userNasabah->id,
            'nis_nip' => '242510190',
            'nama_nasabah' => 'Dinar',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2005-01-01',
            'jurusan' => 2,
            'jenis_kelamin' => 'Laki-Laki',
            'pendidikan' => 'SMA/K',
            'rt_rw' => '01/02',
            'kelurahan' => 'Cibaduyut',
            'kecamatan' => 'Bojongloa',
            'kab_kota' => 'Bandung',
            'provinsi' => 'Jawa Barat',
            'kode_pos' => '40236',
            'email' => 'dinar@gmail.com',
            'agama' => 'Islam',
            'no_hp' => '081936339561',
            'password' => Hash::make('123456'),
            'jabatan' => 'Siswa',
            'jenis_identitas' => 'KTP',
            'nama_kontak_darurat' => 'Ayah Dinar',
            'alamat_kontak_darurat' => 'Bandung',
            'no_hp_kontak_darurat' => '08111111112',
            'hubungan_kontak_darurat' => 'Ayah',
        ]);
    }
}
