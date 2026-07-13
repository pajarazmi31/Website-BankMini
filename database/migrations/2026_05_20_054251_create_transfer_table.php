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

            $table->foreignId('id_rekening_pengirim')
                ->constrained('rekening')
                ->cascadeOnDelete();

            $table->foreignId('id_rekening_penerima')
                ->constrained('rekening')
                ->cascadeOnDelete();

            $table->decimal('jumlah_transfer', 15, 2);

            $table->foreignId('transaksi_id')
                ->nullable();

            $table->decimal('total_biaya', 15, 2);
            $table->decimal('nominal_admin',15,2);

            $table->dateTime('datetime');

            $table->string('catatan')
                ->nullable();

            $table->string('pilihan_biaya_transaksi', 100);

            $table->foreignId('id_petugas')
                ->constrained('petugas')
                ->cascadeOnDelete();

            $table->timestamps();
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
