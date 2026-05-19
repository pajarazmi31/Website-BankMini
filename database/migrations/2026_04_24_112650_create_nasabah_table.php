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
            $table->Enum('jurusan',['1','2','3','4','5','6','7']);
            $table->Enum('jenis_kelamin',['Laki-Laki','Perempuan']);
            $table->Enum('pendidikan',['SD','SMP','SMA','SMK','S1','S2','S3','D1','D2','D3']);
            $table->Text('alamat');
            $table->String('kelurahan', 50);
            $table->String('kecamatan', 50);
            $table->String('kab_kota', 50);
            $table->String('provinsi', 50);
            $table->String('kode_pos', 10);
            $table->String('email', 100);
            $table->Enum('agama',['Islam','Protestan','Katolik','Hindu','Buddha','Konghuchu']);
            $table->String('no_hp', 15);
            $table->String('password');
            $table->Enum('jabatan',['Siswa','Guru','TU']);
            $table->Enum('jenis_identitas', ['KTP','Akta']);
            $table->String('nama_kontak_darurat',100);
            $table->Text('alamat_kontak_darurat');
            $table->String('no_hp_kontak_darurat', 15);
            $table->String('hubungan_kontak_darurat', 50);
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
