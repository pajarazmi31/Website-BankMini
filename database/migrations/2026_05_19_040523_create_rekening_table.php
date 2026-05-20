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
        Schema::create('rekening', function (Blueprint $table) {

            // nomor rekening manual
            $table->string('id')->primary();
            $table->unsignedBigInteger('nasabah_id');
            $table->decimal('saldo_saat_ini', 15, 2)
                  ->default(0);
            $table->enum('status_akun', ['aktif', 'nonaktif'])
                  ->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekening');
    }
};