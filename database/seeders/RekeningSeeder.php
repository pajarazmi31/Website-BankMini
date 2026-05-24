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

        $userNasabah1 = User::create([
            'name' => 'Dika',
            'role_id' => $roleNasabah->id,
            'email' => 'dika@gmail.com',
            'password' => Hash::make('123456'),
            ]);

            Nasabah::create([
            'user_id' => $userNasabah1->id,
            'nis_nip' => '242510190',
            'nama_nasabah' => 'dika',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2005-01-01',
            'jurusan' => 'PPLG',
            'jenis_kelamin' => 'Laki-Laki',
            'pendidikan' => 'SMA/K',
            'rt_rw' => '01/02',
            'kelurahan' => 'Cibaduyut',
            'kecamatan' => 'Bojongloa',
            'kab_kota' => 'Bandung',
            'provinsi' => 'Jawa Barat',
            'kode_pos' => '40236',
            'email' => 'dika@gmail.com',
            'agama' => 'Islam',
            'no_hp' => '08123456789',
            'password' => Hash::make('123456'),
            'jabatan' => 'Siswa',
            'jenis_identitas' => 'KTP',
            'nama_kontak_darurat' => 'Ayah Budi',
            'alamat_kontak_darurat' => 'Bandung',
            'no_hp_kontak_darurat' => '08111111112',
            'hubungan_kontak_darurat' => 'Ayah',
        ]);
            
            $userNasabah2 = User::create([
                'name' => 'Dini',
                'role_id' => $roleNasabah->id,
                'email' => 'dini@gmail.com',
                'password' => Hash::make('123456'),
            ]);

            Nasabah::create([
            'user_id' => $userNasabah2->id,
            'nis_nip' => '242510190',
            'nama_nasabah' => 'dini',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2005-01-01',
            'jurusan' => 'PPLG',
            'jenis_kelamin' => 'Laki-Laki',
            'pendidikan' => 'SMA/K',
            'rt_rw' => '01/02',
            'kelurahan' => 'Cibaduyut',
            'kecamatan' => 'Bojongloa',
            'kab_kota' => 'Bandung',
            'provinsi' => 'Jawa Barat',
            'kode_pos' => '40236',
            'email' => 'dini@gmail.com',
            'agama' => 'Islam',
            'no_hp' => '08123456789',
            'password' => Hash::make('123456'),
            'jabatan' => 'Siswa',
            'jenis_identitas' => 'KTP',
            'nama_kontak_darurat' => 'Ayah dini',
            'alamat_kontak_darurat' => 'Bandung',
            'no_hp_kontak_darurat' => '08111311112',
            'hubungan_kontak_darurat' => 'Ayah',
        ]);

        Rekening::create([
            'id' => 242510190,
           'nasabah_id' => $userNasabah1->id,
           'saldo_saat_ini' => 0,
           'status_akun' => 'nonaktif' 
        ]);

    

        Rekening::create([
            'id' => 242510191,
           'nasabah_id' => $userNasabah2->id,
           'saldo_saat_ini' => 0,
           'status_akun' => 'nonaktif' 
        ]);

    }
}
