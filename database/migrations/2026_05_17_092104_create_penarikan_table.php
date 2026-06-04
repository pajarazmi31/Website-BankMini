<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penarikan', function (Blueprint $table) {

            $table->id();

            $table->string('id_rekening', 20);

            $table->unsignedBigInteger('id_petugas');

            $table->string('nama_penarik', 100);

            $table->foreignId('transaksi_id')
                ->nullable();

            $table->decimal('jumlah_penarikan', 15, 2);

            $table->decimal('biaya_transaksi', 15, 2)
                ->default(0);

            $table->decimal('total_biaya', 15, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penarikan');
    }
};
