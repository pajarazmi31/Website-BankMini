<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penarikan', function (Blueprint $table) {

            $table->decimal('biaya_transaksi', 15, 2)
                  ->default(0)
                  ->after('jumlah_penarikan');

        });
    }

    public function down(): void
    {
        Schema::table('penarikan', function (Blueprint $table) {

            $table->dropColumn('biaya_transaksi');

        });
    }
};