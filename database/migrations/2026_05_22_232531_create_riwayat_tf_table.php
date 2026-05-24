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
        Schema::create('riwayat_tf', function (Blueprint $table) {
            $table->id(); // Ini ID auto-increment untuk baris riwayat (integer)
            
            // Kolom foreign key (Tipe datanya STRING, menyamakan primary key milik tabel rekening)
            $table->string('id_pengirim');
            $table->string('id_penerima');
            
            $table->string('nama_penerima');
            
            // Menggunakan decimal (15, 2) agar aman untuk nominal uang besar dan desimal sen
            $table->decimal('jumlah_transfer', 15, 2); 
            
            // Ditambahkan ->nullable() supaya user tidak wajib mengisi catatan saat transfer
            $table->string('catatan')->nullable(); 
            
            $table->timestamps();

            // Deklarasi Foreign Key resmi di database
            // Artinya: id_pengirim di tabel ini mereferensikan kolom id di tabel rekening
            $table->foreign('id_pengirim')->references('id')->on('rekening')->onDelete('cascade');
            $table->foreign('id_penerima')->references('id')->on('rekening')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_tf');
    }
};