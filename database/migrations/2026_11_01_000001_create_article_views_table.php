<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Mencatat siapa saja (per IP + perangkat) yang sudah membaca sebuah berita,
     * supaya kolom articles.dibaca hanya bertambah sekali per pembaca unik.
     */
    public function up(): void
    {
        Schema::create('article_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            // sha256(IP | User-Agent) - IP asli tidak disimpan.
            $table->string('ip_hash', 64);
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['article_id', 'ip_hash']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_views');
    }
};
