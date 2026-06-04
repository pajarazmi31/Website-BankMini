<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use Illuminate\Database\Seeder;

class BiayaTransaksiSeeder extends Seeder
{
    public function run(): void
    {
        Transaksi::insert([
            [
                'jenis_transaksi' => 'setoran',
                'nominal' => 0,
            ],
            [
                'jenis_transaksi' => 'penarikan',
                'nominal' => 0,
            ],
            [
                'jenis_transaksi' => 'transfer',
                'nominal' => 0,
            ],
        ]);
    }
}