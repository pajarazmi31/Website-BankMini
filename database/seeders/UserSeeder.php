<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Nasabah;
use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ROLE

        $roleNasabah = Role::where('nama_role', 'nasabah')->first();

        $roleTeller = Role::where('nama_role', 'teller')->first();

        $roleSupervisor = Role::where('nama_role', 'supervisor')->first();

        $roleCs = Role::where('nama_role', 'customerservice')->first();

        // USER NASABAH

        $userNasabah = User::create([
            'name' => 'Budi',
            'role_id' => $roleNasabah->id,
            'email' => 'nasabah@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        Nasabah::create([
            'user_id' => $userNasabah->id,
            'nis_nip' => '123456789',
            'nama_nasabah' => 'Budi',
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
            'email' => 'nasabah@gmail.com',
            'agama' => 'Islam',
            'no_hp' => '08123456789',
            'password' => Hash::make('123456'),
            'jabatan' => 'Siswa',
            'jenis_identitas' => 'KTP',
            'nama_kontak_darurat' => 'Ayah Budi',
            'alamat_kontak_darurat' => 'Bandung',
            'no_hp_kontak_darurat' => '08111111111',
            'hubungan_kontak_darurat' => 'Ayah',
        ]);

        // USER TELLER

        $userTeller = User::create([
            'name' => 'Andi',
            'role_id' => $roleTeller->id,
            'email' => 'teller@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        Petugas::create([
            'nama_petugas' => 'Andi',
            'user_id' => $userTeller->id,
            'email' => 'teller@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'teller',
        ]);

        // USER SUPERVISOR

        $userSupervisor = User::create([
            'name' => 'Sinta',
            'role_id' => $roleSupervisor->id,
            'email' => 'supervisor@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        Petugas::create([
            'nama_petugas' => 'Sinta',
            'user_id' => $userSupervisor->id,
            'email' => 'supervisor@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'supervisor',
        ]);


        // USER CUSTOMER SERVICE
        $userCs = User::create([
            'name' => 'Aditya',
            'role_id' => $roleCs->id,
            'email' => 'adityanugrahakawali2@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        Petugas::create([
            'nama_petugas' => 'Aditya',
            'user_id' => $userCs->id,
            'email' => 'adityanugrahakawali2@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'customerservice',
        ]);
    }
}
