<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('master/data_siswa.csv');
        
        if (!file_exists($csvFile)) {
            $this->command->error("File CSV tidak ditemukan di: {$csvFile}");
            return;
        }

        $fileHandle = fopen($csvFile, 'r');
        $header = fgetcsv($fileHandle, 1000, ',');

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($fileHandle, 1000, ',')) !== FALSE) {
                $data = array_combine($header, $row);

                // Eksekusi insert dengan data yang sudah dibersihkan lewat fungsi khusus
                DB::table('data_siswa')->insert([
                    'nama_lengkap'  => $this->cleanValue($data['nama_lengkap']),
                    'nis'           => $this->cleanValue($data['nis']),
                    'nisn'          => $this->cleanValue($data['nisn']),
                    'jenis_kelamin' => $this->cleanValue($data['jenis_kelamin']),
                    'tempat_lahir'  => $this->cleanValue($data['tempat_lahir']),
                    'tanggal_lahir' => $this->cleanValue($data['tanggal_lahir']), // Ini yang bikin error tadi
                    'agama'         => $this->cleanValue($data['agama']),
                    'rt'            => $this->cleanValue($data['rt']),
                    'rw'            => $this->cleanValue($data['rw']),
                    'dusun'         => $this->cleanValue($data['dusun']),
                    'kelurahan'     => $this->cleanValue($data['kelurahan']),
                    'kecamatan'     => $this->cleanValue($data['kecamatan']),
                    'kode_pos'      => $this->cleanValue($data['kode_pos']),
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }
            
            DB::commit();
            $this->command->info("Hore! Data dari file CSV berhasil ditambahkan ke tabel data_siswa.");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("Gagal melakukan seeding data siswa: " . $e->getMessage());
        }

        fclose($fileHandle);
    }

    /**
     * Helper untuk mengubah string kosong atau teks "NULL" menjadi null murni PHP
     */
    private function cleanValue($value)
    {
        $trimmed = trim($value);
        
        // Cek jika kosong, atau berisi teks 'NULL' / 'null'
        if ($trimmed === '' || strtolower($trimmed) === 'null') {
            return null;
        }
        
        return $trimmed;
    }
}