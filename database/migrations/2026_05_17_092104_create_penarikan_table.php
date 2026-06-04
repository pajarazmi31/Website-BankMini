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
        
        // 1. Relasi ke nomor rekening nasabah
        $table->string('id_rekening', 20);
        
        // 2. Relasi ke petugas/users (Biar aman dan bisa ditarik nama petugasnya)
        // Jika nama tabel user lu adalah 'users', gunakan ini. Jika namanya 'petugas', ganti jadi foreignId('id_petugas')->constrained('petugas')
        $table->foreignId('id_petugas')->constrained('users')->onDelete('cascade');
        
        // 3. Nama orang yang melakukan penarikan tunai
        $table->string('nama_penarik', 100);
        
        // 4. Relasi ke histori transaksi besar (jika ada)
        $table->foreignId('transaksi_id')->nullable()->constrained('transaksi')->onDelete('set null');
        
        // 5. Nominal uang yang ditarik nasabah
        $table->decimal('jumlah_penarikan', 15, 2);
        
        // 6. Biaya administrasi penarikan (Krusial buat rincian struk & laporan bray!)
        $table->decimal('biaya_transaksi', 15, 2)->default(0);
        
        // 7. Total saldo yang berkurang dari rekening (jumlah_penarikan + biaya_transaksi)
        $table->decimal('total_biaya', 15, 2);

        // Tanggal transaksi
            $table->dateTime('datetime_tgl');
        
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('penarikan');
    }
};