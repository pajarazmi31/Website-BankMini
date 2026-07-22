<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\User;
use App\Models\Nasabah;
use App\Models\Rekening;
use Maatwebsite\Excel\concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class NasabahImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $row) {
            $user = User::create([
                'name' => $row['name'],
                'role_id' => 1,
                'email' => $row['email'],
                'password' => hash::make($row['password']),
            ]);

            $nasabah = Nasabah::create([
                'user_id' => $user->id,
                'nis_nip' => $row['nis_nip'],
                'nama_nasabah' => $row['name'],
                'tempat_lahir' => $row['tempat_lahir'],
                'tanggal_lahir' => $row['tanggal_lahir'],
                'jurusan_id' => $row['jurusan_id'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'pendidikan' => $row['pendidikan'],
                'alamat' => $row['alamat'],
                'provinsi_id' => $row['provinsi_id'],
                'kab_kota_id' => $row['kab_kota_id'],
                'kecamatan_id' => $row['kecamatan_id'],
                'kelurahan_id' => $row['kelurahan_id'],
                'kode_pos' => $row['kode_pos'],
                'email' => $row['email'],
                'agama' => $row['agama'],
                'no_hp' => $row['no_hp'],
                'password' => hash::make($row['password']),
                'jabatan' => $row['jabatan'],
                'jenis_identitas' => $row['jenis_identitas'],
                'nama_kontak_darurat' => $row['nama_kontak_darurat'],
                'alamat_kontak_darurat' => $row['alamat_kontak_darurat'],
                'no_hp_kontak_darurat' => $row['no_hp_kontak_darurat'],
                'hubungan_kontak_darurat' => $row['hubungan_kontak_darurat'],
                'pesan' => 'belum ada pesan',
                'nama_perevisi' => 'belum ada perevisi',
            ]);


            if ( $row['jabatan'] == 'Siswa' ) {
                $no_rekening = '03' . $row['jurusan_id'] . $row['nis_nip'];
            }

            if ( $row['jabatan'] == 'Guru' ) {
                $tanggal = Carbon::parse($row['tanggal_lahir'])->format('Ymd');
                $urutan = Nasabah::where('jabatan', 'Guru')->count() + 1;
                $no_rekening = '01' . $tanggal . $urutan;
            }

            if ( $row['jabatan'] == 'TU' ) {
                $tanggal = Carbon::parse($row['tanggal_lahir'])->format('Ymd');
                $urutan = Nasabah::where('jabatan', 'TU')->count() + 1;
                $no_rekening = '02' . $tanggal . $urutan;
            }

            Rekening::create([
                'id' => $no_rekening,
                'nasabah_id' => $nasabah->id,
                'saldo_saat_ini' => '0',
                'status_akun' => 'non-aktif',
            ]);


        }


    }
}
