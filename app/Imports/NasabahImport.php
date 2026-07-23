<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\User;
use App\Models\Nasabah;
use App\Models\Rekening;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class NasabahImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $namaNasabah = $row['nama_nasabah'] ?? $row['nama_lengkap'] ?? $row['name'] ?? null;
            $nisNip = $row['nis_nip'] ?? $row['nis'] ?? null;

            // Dilewati jika nama nasabah dan NIS/NIP kosong
            if (empty($namaNasabah) && empty($nisNip)) {
                continue;
            }

            // Dilewati jika NIS/NIP sudah ada di database (mencegah error duplikasi)
            if (!empty($nisNip) && Nasabah::where('nis_nip', $nisNip)->exists()) {
                continue;
            }

            $idJurusan = $row['id_jurusan'] ?? $row['jurusan_id'] ?? $row['jurusan'] ?? 1;
            $tempatLahir = $row['tempat_lahir'] ?? '-';
            $tanggalLahirRaw = $row['tanggal_lahir_yyyy_mm_dd'] ?? $row['tanggal_lahir'] ?? null;

            try {
                $tanggalLahir = $tanggalLahirRaw ? Carbon::parse($tanggalLahirRaw)->format('Y-m-d') : '2000-01-01';
            } catch (\Exception $e) {
                $tanggalLahir = '2000-01-01';
            }

            $jenisKelamin = $row['jenis_kelamin'] ?? 'Laki-Laki';
            $jenisIdentitas = $row['jenis_identitas'] ?? 'KTP';
            $agama = $row['agama'] ?? 'Islam';
            $pendidikan = $row['pendidikan'] ?? 'SD';
            $jabatan = $row['jabatan'] ?? 'Siswa';
            $noHp = $row['no_hp'] ?? $row['telepon_seluler'] ?? '-';
            $email = $row['email'] ?? ($nisNip ? $nisNip . '@bankmini.com' : 'nasabah' . rand(1000, 9999) . '@bankmini.com');
            $alamat = $row['alamat'] ?? '-';

            $idDesa = $row['id_desa'] ?? $row['kelurahan_id'] ?? null;
            $idKecamatan = $row['id_kecamatan'] ?? $row['kecamatan_id'] ?? null;
            $idKabupaten = $row['id_kabupaten'] ?? $row['kab_kota_id'] ?? null;
            $idProvinsi = $row['id_provinsi'] ?? $row['provinsi_id'] ?? null;
            $kodePos = $row['kode_pos'] ?? '00000';

            $namaKontakDarurat = $row['nama_kontak_darurat'] ?? '-';
            $noHpKontakDarurat = $row['no_hp_kontak_darurat'] ?? $row['telepon_pihak_lain'] ?? '-';
            $hubunganKontakDarurat = $row['hubungan_kontak_darurat'] ?? '-';
            $alamatKontakDarurat = $row['alamat_kontak_darurat'] ?? '-';

            $defaultPassword = $nisNip ? (string)$nisNip : '12345678';

            // 1. Buat User Nasabah (role_id = 1)
            $user = User::create([
                'name' => $namaNasabah,
                'role_id' => 1,
                'email' => $email,
                'password' => Hash::make($defaultPassword),
            ]);

            // 2. Buat Data Nasabah
            $nasabah = Nasabah::create([
                'user_id' => $user->id,
                'nis_nip' => $nisNip,
                'nama_nasabah' => $namaNasabah,
                'tempat_lahir' => $tempatLahir,
                'tanggal_lahir' => $tanggalLahir,
                'jurusan_id' => $idJurusan,
                'jenis_kelamin' => $jenisKelamin,
                'pendidikan' => $pendidikan,
                'alamat' => $alamat,
                'kelurahan_id' => $idDesa,
                'kecamatan_id' => $idKecamatan,
                'kab_kota_id' => $idKabupaten,
                'provinsi_id' => $idProvinsi,
                'kode_pos' => $kodePos,
                'email' => $email,
                'agama' => $agama,
                'no_hp' => $noHp,
                'password' => Hash::make($defaultPassword),
                'jabatan' => $jabatan,
                'jenis_identitas' => $jenisIdentitas,
                'nama_kontak_darurat' => $namaKontakDarurat,
                'alamat_kontak_darurat' => $alamatKontakDarurat,
                'no_hp_kontak_darurat' => $noHpKontakDarurat,
                'hubungan_kontak_darurat' => $hubunganKontakDarurat,
                'pesan' => 'belum ada pesan',
                'nama_perevisi' => 'belum ada perevisi',
            ]);

            // 3. Generasi Nomor Rekening Sesuai Jabatan
            $jabatanLower = strtolower($jabatan);
            if ($jabatanLower == 'siswa') {
                $no_rekening = '03' . $idJurusan . $nisNip;
            } elseif ($jabatanLower == 'guru') {
                $tanggal = Carbon::parse($tanggalLahir)->format('Ymd');
                $urutan = Nasabah::where('jabatan', 'Guru')->count() + 1;
                $no_rekening = '01' . $tanggal . $urutan;
            } elseif ($jabatanLower == 'tu') {
                $tanggal = Carbon::parse($tanggalLahir)->format('Ymd');
                $urutan = Nasabah::where('jabatan', 'TU')->count() + 1;
                $no_rekening = '02' . $tanggal . $urutan;
            } else {
                $no_rekening = '03' . $idJurusan . ($nisNip ?? rand(100000, 999999));
            }

            // 4. Buat Rekening Baru
            if (!Rekening::where('id', $no_rekening)->exists()) {
                Rekening::create([
                    'id' => $no_rekening,
                    'nasabah_id' => $nasabah->id,
                    'saldo_saat_ini' => '0',
                    'status_akun' => 'non-aktif',
                ]);
            }
        }
    }
}
