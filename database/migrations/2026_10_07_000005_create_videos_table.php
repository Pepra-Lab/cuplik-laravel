<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('link');
            $table->string('durasi')->nullable();
            $table->unsignedBigInteger('dibaca')->default(0);
            $table->date('tanggal')->nullable();
            $table->string('status')->default('Tayang'); // Tayang, Draft
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
