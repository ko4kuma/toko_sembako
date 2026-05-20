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
        Schema::table('detail_transaksis', function (Blueprint $table) {
            $table->dropColumn('harga_satuan');
            $table->decimal('subtotal', 12, 2)->after('qty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_transaksis', function (Blueprint $table) {
            $table->dropColumn('subtotal');
            $table->decimal('harga_satuan', 12, 2)->after('jumlah');
        });
    }
};