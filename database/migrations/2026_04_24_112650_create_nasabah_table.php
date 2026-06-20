<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nasabah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->String('nis_nip',30);
            $table->String('nama_nasabah');
            $table->String('tempat_lahir', 50);
            $table->Date('tanggal_lahir');
            $table->foreignId('jurusan_id')->constrained('jurusan');
            $table->Enum('jenis_kelamin',['Laki-Laki','Perempuan']);
            $table->Enum('pendidikan',['SD','SMP','SMA','SMK','S1','S2','S3','D1','D2','D3']);
            $table->Text('alamat');
            $table->foreignId('provinsi_id')->constrained('provinsi');
            $table->foreignId('kab_kota_id')->constrained('kabupaten');
            $table->foreignId('kecamatan_id')->constrained('kecamatan');
            $table->foreignId('kelurahan_id')->constrained('desa');
            $table->String('kode_pos', 10);
            $table->String('email', 100);
            $table->Enum('agama',['Islam','Protestan','Katolik','Hindu','Buddha','Konghuchu']);
            $table->String('no_hp', 15);
            $table->String('password');
            $table->Enum('jabatan',['Siswa','Guru','TU']);
            $table->Enum('jenis_identitas', ['KTP','Kartu Keluarga']);
            $table->String('nama_kontak_darurat',100);
            $table->Text('alamat_kontak_darurat');
            $table->String('no_hp_kontak_darurat', 15);
            $table->String('hubungan_kontak_darurat', 50);
            $table->Text('pesan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nasabah');
    }
};
