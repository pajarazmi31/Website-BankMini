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

        DB::beginTransaction();
        $insertData = [];
        $chunkSize = 1000;

        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            $insertData[] = [
                'id' => $data[0],
                'kecamatan_id' => $data[1],
                'name' => $data[2],
            ];

            if (count($insertData) >= $chunkSize) {
                DB::table('desa')->insert($insertData);
                $insertData = [];
            }
        }

        if (count($insertData) > 0) {
            DB::table('desa')->insert($insertData);
        }

        DB::commit();
        fclose($file);
    }
}
