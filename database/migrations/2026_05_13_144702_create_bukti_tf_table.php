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
        Schema::create('bukti_tf', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksi');
            $table->String('nama_pengirim',100);
            $table->String('no_hp_pengirim',15);
            $table->String('id_rekening',20);
            $table->decimal('nominal_admin',15,2);
            $table->decimal('jumlah_transfer',15,2);
            $table->String('bukti_foto');
            $table->String('nama_penerima',100);
            $table->enum('status_verifikasi',['pending','berhasil','gagal'])->default('pending');
            $table->date('datetime_tgl');
            $table->String('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_tf');
    }
};
