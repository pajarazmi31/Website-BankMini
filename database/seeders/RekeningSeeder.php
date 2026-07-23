<?php

namespace Database\Seeders;

use App\Models\Rekening;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Nasabah;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RekeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $roleNasabah = Role::where('nama_role', 'nasabah')->first();
                

        $userNasabah = User::create([
            'name' => 'Nasabah',
            'role_id' => $roleNasabah->id,
            'email' => 'nasabah@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        $nasabah = Nasabah::create([
            'user_id' => $userNasabah->id,
            'nis_nip' => '242510190',
            'nama_nasabah' => 'Nasabah',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2005-01-01',
            'jurusan_id' => '3',
            'jenis_kelamin' => 'Laki-Laki',
            'pendidikan' => 'SMA',
            'alamat' => 'sindangraja',
            'kelurahan_id' => 1101010001,
            'kecamatan_id' => 1101010,
            'kab_kota_id' => 1101,
            'provinsi_id' => 11,
            'kode_pos' => '40236',
            'email' => 'nasabah@gmail.com',
            'agama' => 'Islam',
            'no_hp' => '08193456789',
            'password' => Hash::make('123456'),
            'jabatan' => 'Siswa',
            'jenis_identitas' => 'KTP',
            'nama_kontak_darurat' => 'Ayah Budi',
            'alamat_kontak_darurat' => 'Bandung',
            'no_hp_kontak_darurat' => '08111111111',
            'hubungan_kontak_darurat' => 'Ayah',
            'pesan' => 'pesan',
            'nama_perevisi' => '-',
        ]);

        Rekening::create([
            'id' => 242510190,
           'nasabah_id' => $nasabah->id,
           'saldo_saat_ini' => 0,
           'status_akun' => 'aktif' 
        ]);

        $userSiswa = User::create([
            'name' => 'Siswa',
            'role_id' => $roleNasabah->id,
            'email' => 'siswa@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        $siswa = Nasabah::create([
            'user_id' => $userSiswa->id,
            'nis_nip' => '242510191',
            'nama_nasabah' => 'Siswa',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2005-01-01',
            'jurusan_id' => '3',
            'jenis_kelamin' => 'Laki-Laki',
            'pendidikan' => 'SMA',
            'alamat' => 'sindangraja',
            'kelurahan_id' => 1101010001,
            'kecamatan_id' => 1101010,
            'kab_kota_id' => 1101,
            'provinsi_id' => 11,
            'kode_pos' => '40236',
            'email' => 'siswa@gmail.com',
            'agama' => 'Islam',
            'no_hp' => '08193456789',
            'password' => Hash::make('123456'),
            'jabatan' => 'Siswa',
            'jenis_identitas' => 'KTP',
            'nama_kontak_darurat' => 'Ayah Budi',
            'alamat_kontak_darurat' => 'Bandung',
            'no_hp_kontak_darurat' => '08111111111',
            'hubungan_kontak_darurat' => 'Ayah',
            'pesan' => 'pesan',
            'nama_perevisi' => '-',
        ]);

        Rekening::create([
            'id' => 242510191,
           'nasabah_id' => $siswa->id,
           'saldo_saat_ini' => 0,
           'status_akun' => 'aktif' 
        ]);
    }
}