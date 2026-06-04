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

        // 1. Relasi Rekening Pengirim & Penerima
        $table->string('id_rekening_pengirim', 20);
        $table->string('id_rekening_penerima', 20);

        // 2. Data Nominal Transfer
        $table->decimal('jumlah_transfer', 15, 2);
        
        // 3. Tambahan: Biaya admin transfer (Biar sinkron dengan total_biaya, bray!)
        $table->decimal('biaya_transaksi', 15, 2)->default(0);
        
        // 4. Total saldo yang didebet dari pengirim (jumlah_transfer + biaya_transaksi)
        $table->decimal('total_biaya', 15, 2);

        // 5. Relasi ke master transaksi utama (Foreign Key ke tabel transaksi)
        $table->foreignId('transaksi_id')->nullable()->constrained('transaksi')->onDelete('set null');

        // 6. Metadata waktu & catatan
        $table->dateTime('datetime');
        $table->string('catatan', 255)->nullable();

        // 7. Relasi ke Petugas yang memproses
        $table->unsignedBigInteger('id_petugas');

        // ==================== Foreign Key Constraints ====================
        $table->foreign('id_rekening_pengirim')
              ->references('id')
              ->on('rekening')
              ->onDelete('cascade');

        $table->foreign('id_rekening_penerima')
              ->references('id')
              ->on('rekening')
              ->onDelete('cascade');

        $table->foreign('id_petugas')
              ->references('id')
              ->on('petugas')
              ->onDelete('cascade');

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