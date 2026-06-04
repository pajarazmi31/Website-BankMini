<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $file = fopen(database_path('master/districts.csv'), 'r');

    while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {

    DB::table('kecamatan')->insert([
        'id' => $data[0],
        'kabupaten_id' => $data[1],
        'name' => $data[2],
    ]);
}
    }
}
