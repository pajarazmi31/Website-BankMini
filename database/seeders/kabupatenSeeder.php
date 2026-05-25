<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class kabupatenSeeder extends Seeder
{


public function run(): void
{
    $file = fopen(database_path('master/regencies.csv'), 'r');

    while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {

        DB::table('kabupaten')->insert([
            'id' => $data[0],
            'provinsi_id' => $data[1],
            'name' => $data[2],
        ]);
    }

    fclose($file);
}
}
