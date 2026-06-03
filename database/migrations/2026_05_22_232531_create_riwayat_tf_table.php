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
            $table->id();

            $table->unsignedBigInteger('id_pengirim');
            $table->unsignedBigInteger('id_penerima');

            $table->string('nama_penerima');
            $table->decimal('jumlah_transfer', 15, 2);
            $table->string('catatan')->nullable();

            $table->timestamps();

            $table->foreign('id_pengirim')
                ->references('id')
                ->on('rekening')
                ->onDelete('cascade');

            $table->foreign('id_penerima')
                ->references('id')
                ->on('rekening')
                ->onDelete('cascade');
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
