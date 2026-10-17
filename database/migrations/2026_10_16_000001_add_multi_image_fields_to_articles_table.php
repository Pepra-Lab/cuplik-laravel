<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasColumn('articles', 'foto_2')) {
                $table->string('foto_2')->nullable()->after('foto');
            }
            if (!Schema::hasColumn('articles', 'foto_posisi')) {
                $table->string('foto_posisi')->default('header')->after('foto_2');
            }
            if (!Schema::hasColumn('articles', 'foto_2_posisi')) {
                $table->string('foto_2_posisi')->default('p2')->after('foto_posisi');
            }
            if (!Schema::hasColumn('articles', 'caption_foto')) {
                $table->string('caption_foto')->nullable()->after('foto_2_posisi');
            }
            if (!Schema::hasColumn('articles', 'caption_foto_2')) {
                $table->string('caption_foto_2')->nullable()->after('caption_foto');
            }
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn([
                'foto_2',
                'foto_posisi',
                'foto_2_posisi',
                'caption_foto',
                'caption_foto_2',
            ]);
        });
    }
};
