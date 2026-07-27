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
        Schema::create('data_siswa', function (Blueprint $table) {
            $table->id();
            $table->String('nama_lengkap');
            $table->String('nis');
            $table->String('nisn');
            $table->foreignId('jurusan_id')->constrained('jurusan');
            $table->String('jenis_kelamin');
            $table->String('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->String('agama');
            $table->String('rt');
            $table->String('rw');
            $table->String('dusun');
            $table->String('kelurahan_id');
            $table->String('kecamatan_id');
            $table->String('kode_pos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_siswa');
    }
};
