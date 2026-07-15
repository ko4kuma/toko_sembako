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
    Schema::table('stoks', function (Blueprint $table) {
        $table->enum('jenis', ['masuk', 'keluar', 'penyesuaian'])->after('barang_id');
        $table->integer('stok_sebelum')->after('jenis');
        $table->integer('stok_sesudah')->after('stok_sebelum');
        $table->nullableMorphs('referensi'); 
        $table->text('keterangan')->nullable()->after('referensi_id');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stoks', function (Blueprint $table) {
            $table->dropColumn(['jenis', 'stok_sebelum', 'stok_sesudah', 'keterangan']);
            $table->dropMorphs('referensi');
        });
    }
};
