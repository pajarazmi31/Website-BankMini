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
        Schema::create('transfer', function (Blueprint $table) {

            $table->id();

            $table->string('id_rekening_pengirim', 20);

            $table->string('id_rekening_penerima', 20);

            $table->decimal('jumlah_transfer', 15, 2);

            $table->foreignId('transaksi_id')
                ->nullable();

            $table->decimal('total_biaya', 15, 2);

            $table->dateTime('datetime');

            $table->string('catatan')
                ->nullable();

            $table->foreignId('id_petugas')
                ->constrained('petugas')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->foreign('id_rekening_pengirim')
                ->references('id')
                ->on('rekening')
                ->cascadeOnDelete();

            $table->foreign('id_rekening_penerima')
                ->references('id')
                ->on('rekening')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer');
    }
};
