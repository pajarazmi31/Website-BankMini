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
            'name' => 'Kirin',
            'role_id' => $roleNasabah->id,
            'email' => 'kirin@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        $nasabah = Nasabah::create([
            'user_id' => $userNasabah->id,
            'nis_nip' => '242510191',
            'nama_nasabah' => 'Kirin',
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
            'email' => 'kirin@gmail.com',
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
        ]);

        Rekening::create([
            'id' => 242510191,
           'nasabah_id' => $userNasabah->id,
           'saldo_saat_ini' => 100000,
           'status_akun' => 'aktif' 
        ]);
        
        $userNasabah = User::create([
            'name' => 'Dika',
            'role_id' => $nasabah->id,
            'email' => 'dika@gmail.com',
            'password' => Hash::make('123456'),
        ]);

       $nasabah = Nasabah::create([
            'user_id' => $userNasabah->id,
            'nis_nip' => '242510190',
            'nama_nasabah' => 'Dika',
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
            'email' => 'dika@gmail.com',
            'agama' => 'Islam',
            'no_hp' => '08123456789',
            'password' => Hash::make('123456'),
            'jabatan' => 'Siswa',
            'jenis_identitas' => 'KTP',
            'nama_kontak_darurat' => 'Ayah dika',
            'alamat_kontak_darurat' => 'Bandung',
            'no_hp_kontak_darurat' => '08111112111',
            'hubungan_kontak_darurat' => 'Ayah',
            'pesan' => 'pesan',
        ]);

        Rekening::create([
            'id' => 242510190,
           'nasabah_id' => $nasabah->id,
           'saldo_saat_ini' => 100000,
           'status_akun' => 'aktif' 
        ]);

        $userNasabah = User::create([
            'name' => 'Dida',
            'role_id' => $roleNasabah->id,
            'email' => 'dida@gmail.com',
            'password' => Hash::make('123456'),
        ]);

       $nasabah = Nasabah::create([
            'user_id' => $userNasabah->id,
            'nis_nip' => '242510192',
            'nama_nasabah' => 'Dida',
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
            'email' => 'dida@gmail.com',
            'agama' => 'Islam',
            'no_hp' => '08123456789',
            'password' => Hash::make('123456'),
            'jabatan' => 'Siswa',
            'jenis_identitas' => 'KTP',
            'nama_kontak_darurat' => 'Ayah dika',
            'alamat_kontak_darurat' => 'Bandung',
            'no_hp_kontak_darurat' => '08131112111',
            'hubungan_kontak_darurat' => 'Ayah',
            'pesan' => 'pesan',
        ]);

        Rekening::create([
            'id' => 242510192,
           'nasabah_id' => $nasabah->id,
           'saldo_saat_ini' => 100000,
           'status_akun' => 'aktif' 
        ]);
    }
}
