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
            // 1. id bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->id(); 
            
            // 2-6. Kolom varchar(255) bawaan Laravel menggunakan string() yang default-nya 255
            $table->string('nama_lengkap');
            
            // 3 & 4. Kolom nis dan nisn dengan constraint UNIQUE (Null: Yes)
            $table->string('nis')->nullable()->unique();
            $table->string('nisn')->nullable()->unique();
            
            $table->string('jenis_kelamin')->nullable();
            $table->string('tempat_lahir')->nullable();
            
            // 7. tanggal_lahir date (Null: Yes)
            $table->date('tanggal_lahir')->nullable();
            
            // 8-14. Kolom alamat dan data penunjang (Null: Yes)
            $table->string('agama')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('dusun')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kode_pos')->nullable();
            
            // 15 & 16. created_at dan updated_at timestamp (Null: Yes)
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