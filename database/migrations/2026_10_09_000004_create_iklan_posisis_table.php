<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iklan_posisis', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Header, Sidebar, Artikel, dst.
            $table->string('ukuran')->nullable(); // 728x90, 300x250, dst.
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iklan_posisis');
    }
};
