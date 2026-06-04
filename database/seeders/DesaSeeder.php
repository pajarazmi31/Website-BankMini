<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $file = fopen(database_path('master/villages.csv'), 'r');

            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {

            DB::table('desa')->insert([
                'id' => $data[0],
                'kecamatan_id' => $data[1],
                'name' => $data[2],
            ]);
        }
    }
}
