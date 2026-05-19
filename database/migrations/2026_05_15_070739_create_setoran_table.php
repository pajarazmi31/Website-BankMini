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

            // nomor rekening dari tb_rekening.id
            $table->string('id_rekening');

            // id user login / petugas
            $table->unsignedBigInteger('id_petugas');

            // jenis setoran
            $table->enum('setoran', ['tunai', 'warkat']);

            // mata uang
            $table->string('mata_uang')->default('rupiah');

            // nominal setoran
            $table->decimal('jumlah_penyetoran', 15, 2);

            // hasil terbilang
            $table->string('uang_terbilang')->nullable();

            // biaya admin/transaksi
            $table->decimal('biaya_transaksi', 15, 2)
                  ->default(0);

            // total setelah biaya
            $table->decimal('total_biaya', 15, 2);

            // data penyetoran
            $table->string('nama_lengkap');
                  
            // data penyetor
            $table->string('nama_penyetor')
                  ->nullable();

            $table->text('alamat_penyetor')
                  ->nullable();

            $table->string('no_hp_penyetor')
                  ->nullable();

            // catatan transaksi
            $table->text('catatan')
                  ->nullable();

            // tanggal transaksi
            $table->dateTime('datetime_tgl');

            $table->timestamps();

            // foreign key rekening
            $table->foreign('id_rekening')
                  ->references('id')
                  ->on('rekening')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

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