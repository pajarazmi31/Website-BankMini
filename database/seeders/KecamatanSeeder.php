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

        DB::beginTransaction();
        $insertData = [];
        $chunkSize = 1000;

        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            $insertData[] = [
                'id' => $data[0],
                'kabupaten_id' => $data[1],
                'name' => $data[2],
            ];

            if (count($insertData) >= $chunkSize) {
                DB::table('kecamatan')->insert($insertData);
                $insertData = [];
            }
        }

        if (count($insertData) > 0) {
            DB::table('kecamatan')->insert($insertData);
        }

        DB::commit();
        fclose($file);
    }
}
