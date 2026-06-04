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
        Schema::create('setoran', function (Blueprint $table) {
            $table->id();

            // 1. Diubah jadi foreignId agar tipenya klop dengan rekening.id (Unsigned Big Int)
            $table->foreignId('id_rekening')
                  ->constrained('rekening')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            // 2. Diubah jadi foreignId agar mengunci resmi ke tabel petugas
            $table->foreignId('id_petugas')
                  ->constrained('petugas')
                  ->onDelete('cascade');

            // Jenis setoran
            $table->enum('setoran', ['tunai', 'warkat']);

            // Mata uang
            $table->string('mata_uang')->default('rupiah');

            // Nominal setoran
            $table->decimal('jumlah_penyetoran', 15, 2);

            // Hasil terbilang
            $table->string('uang_terbilang')->nullable();

            // 3. Dikunci resmi ke master tabel transaksi untuk mencatat id master biaya admin
            $table->foreignId('transaksi_id')
                  ->nullable()
                  ->constrained('transaksi')
                  ->onDelete('set null');

            // Total setelah biaya
            $table->decimal('total_biaya', 15, 2);

            // Data penyetoran
            $table->string('nama_lengkap');
                  
            // Data penyetor
            $table->string('nama_penyetor')->nullable();
            $table->text('alamat_penyetor')->nullable();
            $table->string('no_hp_penyetor')->nullable();

            // Catatan transaksi
            $table->text('catatan')->nullable();

            // Tanggal transaksi
            $table->dateTime('datetime_tgl');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setoran');
    }
};