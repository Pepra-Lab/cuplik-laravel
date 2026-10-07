<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('editor_nama')->nullable();
            $table->string('penulis_nama')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('lead')->nullable();
            $table->longText('isi');
            $table->string('foto')->nullable();
            $table->string('tone')->default('#eaf3ec');
            $table->unsignedBigInteger('dibaca')->default(0);
            $table->string('status')->default('Terbit'); // Terbit, Review, Draft
            $table->date('tanggal')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
