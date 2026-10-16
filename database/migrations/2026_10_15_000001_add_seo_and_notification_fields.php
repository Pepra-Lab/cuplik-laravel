<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('meta_title', 70)->nullable()->after('status');
            $table->string('meta_description', 160)->nullable()->after('meta_title');
            $table->string('meta_image')->nullable()->after('meta_description');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('notifikasi_artikel_aktif')->default(true)->after('footer_text');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description', 'meta_image']);
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('notifikasi_artikel_aktif');
        });
    }
};
