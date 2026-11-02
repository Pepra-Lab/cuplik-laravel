<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pembaca yang sama (IP + perangkat) dihitung lagi setelah 24 jam.
     * Kolom viewed_at menyimpan kapan terakhir kali pembaca itu dihitung.
     */
    public function up(): void
    {
        Schema::table('article_views', function (Blueprint $table) {
            $table->timestamp('viewed_at')->nullable()->after('ip_hash')->index();
        });

        // Baris lama: anggap terakhir dihitung saat pertama kali tercatat.
        DB::table('article_views')->update(['viewed_at' => DB::raw('created_at')]);
    }

    public function down(): void
    {
        Schema::table('article_views', function (Blueprint $table) {
            $table->dropIndex(['viewed_at']);
            $table->dropColumn('viewed_at');
        });
    }
};
