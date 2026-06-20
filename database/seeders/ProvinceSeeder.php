<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{


public function run(): void
{
    $file = fopen(database_path('master/provinces.csv'), 'r');

    while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {

        DB::table('provinsi')->insert([
            'id' => $data[0],
            'name' => $data[1],
        ]);
    }

    fclose($file);
}
}
