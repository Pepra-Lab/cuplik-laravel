<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iklan_gambars', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('posisi'); // Header 728x90, Sidebar 300x250, Artikel 640x200
            $table->string('ukuran')->nullable();
            $table->string('link')->nullable();
            $table->string('gambar')->nullable();
            $table->date('mulai')->nullable();
            $table->date('selesai')->nullable();
            $table->string('status')->default('Tayang'); // Tayang, Berakhir, Nonaktif
            $table->timestamps();
        });

        Schema::create('iklan_baris', function (Blueprint $table) {
            $table->id();
            $table->string('pemasang');
            $table->string('kategori'); // Jual Beli, Properti, Kendaraan, Lowongan
            $table->text('isi');
            $table->date('tanggal')->nullable();
            $table->string('status')->default('Menunggu'); // Menunggu, Disetujui, Ditolak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iklan_baris');
        Schema::dropIfExists('iklan_gambars');
    }
};
