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
