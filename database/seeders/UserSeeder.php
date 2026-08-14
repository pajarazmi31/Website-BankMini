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
        // AMBIL DATA ROLE
        $roleTeller = Role::where('nama_role', 'teller')->first();
        $roleSupervisor = Role::where('nama_role', 'supervisor')->first();
        $roleCs = Role::where('nama_role', 'customerservice')->first();


        // 1. USER SUPERVISOR (Hanya 1 Role)
        $userSupervisor = User::create([
            'name' => 'Supervisor',
            'role_id' => $roleSupervisor->id,
            // role_id_2 otomatis null karena tidak diisi
            'email' => 'supervisor@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        Petugas::create([
            'user_id' => $userSupervisor->id,
            'kelas' => 'XI AK 1',
        ]);


        // 2. USER GABUNGAN (TELLER & CUSTOMER SERVICE)
        $userMulti = User::create([
            'name' => 'Petugas Bank (Teller & CS)',
            'role_id' => $roleTeller->id,        // Slot Role Utama
            'role_id_2' => $roleCs->id,          // Slot Role Kedua
            'email' => 'petugas@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        Petugas::create([
            'user_id' => $userMulti->id,
            'kelas' => 'XI AK 1',
        ]);
    }
}