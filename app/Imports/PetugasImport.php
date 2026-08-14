<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Petugas;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PetugasImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Cek apakah email sudah terdaftar untuk menghindari crash duplikat di level DB
            $existingUser = User::where('email', $row['email'])->first();
            if ($existingUser) {
                continue; 
            }

            // Set Role ID ke 2 (Teller) dan Role ID 2 ke 3 (Customer Service)
            $roleId = 2;
            $roleId2 = 3; 

            DB::transaction(function () use ($row, $roleId, $roleId2) {
                // Simpan ke tabel users dengan 2 role sekaligus
                $user = User::create([
                    'name'      => $row['nama_petugas'], 
                    'email'     => $row['email'],
                    'password'  => Hash::make($row['password'] ?? 'password123'),
                    'role_id'   => $roleId,
                    'role_id_2' => $roleId2, // Menambahkan role kedua di sini
                ]);

                // Simpan ke tabel petugas
                Petugas::create([
                    'user_id' => $user->id,
                    'kelas'   => $row['kelas'] ?? '-',
                ]);
            });
        }
    }

    /**
     * Rules validasi untuk mengecek isi Excel sebelum di-insert
     */
    public function rules(): array
    {
        return [
            'nama_petugas' => 'required|string',
            'email'        => 'required|email',
            'kelas'        => 'nullable',
        ];
    }

    /**
     * Kustomisasi pesan error validasi
     */
    public function customValidationMessages()
    {
        return [
            'nama_petugas.required' => 'Kolom Nama Petugas tidak boleh kosong.',
            'email.required'        => 'Kolom Email tidak boleh kosong.',
            'email.email'           => 'Format Email tidak valid.',
        ];
    }
}