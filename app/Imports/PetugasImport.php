<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Petugas;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PetugasImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Abaikan jika baris kosong
            if (empty($row['nama_petugas']) || empty($row['email'])) {
                continue;
            }

            // Cek duplikasi email pada tabel users
            $existingUser = User::where('email', $row['email'])->first();
            if ($existingUser) {
                continue; 
            }

            // Jalankan transaksi database untuk insert ke dua tabel
            DB::transaction(function () use ($row) {
                $user = User::create([
                    'name'     => $row['nama_petugas'],
                    'email'    => $row['email'],
                    'password' => Hash::make($row['password'] ?? 'password123'),
                    'role_id'  => $row['role_id_lihat_sheet_referensi_role'],
                ]);

                Petugas::create([
                    'user_id' => $user->id,
                    'kelas'   => $row['kelas'] ?? '-', // Fallback jika kelas kosong
                ]);
            });
        }
    }
}