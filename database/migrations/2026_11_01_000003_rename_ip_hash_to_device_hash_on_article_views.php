<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pembaca tidak lagi dikenali dari IP, tetapi dari token perangkat di cookie,
     * sehingga dua hp di wifi yang sama dihitung sebagai dua pembaca.
     */
    public function up(): void
    {
        // Isi lama berbasis IP + user agent dan tidak cocok dengan cara baru.
        // Tabel ini hanya cache 24 jam, jadi aman dikosongkan.
        DB::table('article_views')->delete();

        Schema::table('article_views', function (Blueprint $table) {
            $table->renameColumn('ip_hash', 'device_hash');
        });
    }

    public function down(): void
    {
        DB::table('article_views')->delete();

        Schema::table('article_views', function (Blueprint $table) {
            $table->renameColumn('device_hash', 'ip_hash');
        });
    }
};
