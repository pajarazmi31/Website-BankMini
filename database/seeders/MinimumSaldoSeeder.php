<?php

namespace Database\Seeders;

use App\Models\Minimum_saldo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MinimumSaldoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Minimum_saldo::insert([
        [
                'jenis_minimum' => 'penarikan',
                'nominal' => 2000,
        ],
        ]);
    }
}
