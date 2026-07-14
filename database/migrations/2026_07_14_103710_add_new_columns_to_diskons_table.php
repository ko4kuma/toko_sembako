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
        Schema::table('diskons', function (Blueprint $table) {
            $table->enum('tipe', ['umum', 'member'])->after('nama_diskon');
            $table->unsignedBigInteger('syarat_minimal')->after('tipe');
            $table->date('berlaku_mulai')->nullable()->after('persentase');   // dipakai kalau tipe diskon umum (musiman)
            $table->date('berlaku_sampai')->nullable()->after('berlaku_mulai');
            $table->boolean('aktif')->default(true)->after('berlaku_sampai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diskons', function (Blueprint $table) {
            $table->dropColumn(['tipe','syarat_minimal', 'berlaku_mulai', 'berlaku_sampai', 'aktif']);
        });
    }
};
