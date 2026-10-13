<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iklan_kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique(); // Jual Beli, Properti, Kendaraan, dst.
            $table->timestamps();
        });

        // Data kategori default agar iklan baris yang sudah ada tetap konsisten.
        $default = ['Jual Beli', 'Properti', 'Kendaraan', 'Lowongan'];
        $now = now();

        \DB::table('iklan_kategoris')->insert(
            array_map(fn (string $nama) => [
                'nama' => $nama,
                'created_at' => $now,
                'updated_at' => $now,
            ], $default)
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('iklan_kategoris');
    }
};
