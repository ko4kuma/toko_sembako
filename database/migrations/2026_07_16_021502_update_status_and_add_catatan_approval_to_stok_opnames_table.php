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
        Schema::table('stok_opnames', function (Blueprint $table) {
            $table->text('catatan_approval')->nullable()->after('keterangan');
        });

        // Ubah enum status - perlu raw SQL karena Laravel gak punya method langsung buat modify enum
        DB::statement("ALTER TABLE stok_opnames MODIFY status ENUM('draft', 'menunggu_approval', 'disetujui') DEFAULT 'draft'");
    }

    public function down(): void
    {
        Schema::table('stok_opnames', function (Blueprint $table) {
            $table->dropColumn('catatan_approval');
        });

        DB::statement("ALTER TABLE stok_opnames MODIFY status ENUM('draft', 'selesai') DEFAULT 'draft'");
    }
};
