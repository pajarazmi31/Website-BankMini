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

        $roleTeller = Role::where('nama_role', 'teller')->first();

        $roleSupervisor = Role::where('nama_role', 'supervisor')->first();

        $roleCs = Role::where('nama_role', 'customerservice')->first();


        // USER TELLER

        $userTeller = User::create([
            'name' => 'Teller',
            'role_id' => $roleTeller->id,
            'email' => 'teller@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        Petugas::create([
            'user_id' => $userTeller->id,
            'kelas' => 'XI AK 1',
        ]);

        // USER SUPERVISOR

        $userSupervisor = User::create([
            'name' => 'Supervisor',
            'role_id' => $roleSupervisor->id,
            'email' => 'supervisor@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        Petugas::create([
            'user_id' => $userSupervisor->id,
            'kelas' => 'XI AK 1',
        ]);


        // USER CUSTOMER SERVICE
        $userCs = User::create([
            'name' => 'Customer Service',
            'role_id' => $roleCs->id,
            'email' => 'customerservice@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        Petugas::create([
            'user_id' => $userCs->id,
            'kelas' => 'XI AK 1',
        ]);
    }
}
