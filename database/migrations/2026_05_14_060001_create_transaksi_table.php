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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();

            // Di-set unique biar nama jenis transaksinya tidak dobel-dobel di database bray
            $table->string('jenis_transaksi')->unique();
            
            // Diubah ke decimal biar presisi dan sinkron dengan modul transfer/penarikan
            $table->decimal('nominal', 15, 2);

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
