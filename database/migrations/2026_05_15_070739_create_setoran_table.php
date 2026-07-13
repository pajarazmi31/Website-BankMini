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

            $table->unsignedBigInteger('id_rekening');

            $table->foreignId('id_petugas');

            $table->enum('setoran', [
                'tunai',
                'warkat'
            ]);

            $table->string('mata_uang')
                ->default('rupiah');

            $table->decimal('jumlah_penyetoran', 15, 2);

            $table->string('uang_terbilang')
                ->nullable();

            $table->foreignId('transaksi_id')
                ->nullable();

            $table->decimal('total_biaya', 15, 2);
            $table->decimal('nominal_admin',15,2);
            $table->string('pilihan_biaya_transaksi', 100);

            $table->string('nama_lengkap');

            $table->string('nama_penyetor')
                ->nullable();

            $table->text('alamat_penyetor')
                ->nullable();

            $table->string('no_hp_penyetor')
                ->nullable();

            $table->text('catatan')
                ->nullable();

            $table->timestamps();

            $table->foreign('id_rekening')
                ->references('id')
                ->on('rekening')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
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
