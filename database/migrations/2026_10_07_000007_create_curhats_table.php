<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curhats', function (Blueprint $table) {
            $table->id();
            $table->string('pengirim')->default('Anonim');
            $table->string('lokasi')->nullable();
            $table->text('pesan');
            $table->date('tanggal')->nullable();
            $table->string('status')->default('Baru'); // Baru, Tampil, Disembunyikan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curhats');
    }
};
