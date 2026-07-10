<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            BiayaTransaksiSeeder::class,
            JurusanSeeder::class,
            ProvinceSeeder::class,
            kabupatenSeeder::class,
            KecamatanSeeder::class,
            DesaSeeder::class,
            DataSiswaSeeder::class,
            UserSeeder::class,
            RekeningSeeder::class,
        ]);
    }
}
