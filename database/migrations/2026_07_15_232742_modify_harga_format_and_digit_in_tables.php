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
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->unsignedBigInteger('kembalian')->default(0)->after('jumlah')->change();
            $table->unsignedBigInteger('jumlah')->default(0)->after('metode')->change();
        });
        Schema::table('transaksis', function (Blueprint $table) {
            $table->unsignedBigInteger('total')->default(0)->after('tanggal')->change();
        });

        Schema::table('detail_transaksis', function (Blueprint $table) {
            $table->unsignedBigInteger('harga_satuan')->after('qty')->change();
        });
        Schema::table('barangs', function (Blueprint $table) {
            $table->unsignedBigInteger('harga')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->decimal('kembalian', 12, 2)->default(0)->after('jumlah');
            $table->decimal('jumlah', 12, 2);
        });
        Schema::table('transaksis', function (Blueprint $table) {
            $table->decimal('total')->default(0)->after('tanggal')->change();
        });
        Schema::table('detail_transaksis', function (Blueprint $table) {
            $table->decimal('harga_satuan', 12, 2)->after('qty');
        });
        Schema::table('barangs', function (Blueprint $table) {
            $table->decimal('harga', 12, 2);
        });
    }
};