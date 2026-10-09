<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('banners');
        Schema::dropIfExists('newsletter_subscribers');

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['banner_jeda', 'newsletter_aktif', 'newsletter_subjek_default']);
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->unsignedInteger('banner_jeda')->default(10);
            $table->boolean('newsletter_aktif')->default(true);
            $table->string('newsletter_subjek_default')->nullable();
        });

        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->date('tanggal')->nullable();
            $table->timestamps();
        });

        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('gambar')->nullable();
            $table->string('tautan')->nullable();
            $table->integer('urutan')->default(0);
            $table->string('tampil')->default('Ya');
            $table->timestamps();
        });
    }
};
