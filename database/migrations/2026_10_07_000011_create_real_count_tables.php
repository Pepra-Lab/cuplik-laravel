<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pilbups', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->integer('tahun');
            $table->string('status')->default('Aktif'); // Aktif, Selesai
            $table->timestamps();
        });

        Schema::create('paslons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pilbup_id')->constrained('pilbups')->cascadeOnDelete();
            $table->integer('no_urut');
            $table->string('nama');
            $table->string('usungan')->nullable();
            $table->string('warna')->default('#008a24');
            $table->string('foto')->nullable();
            $table->timestamps();
        });

        Schema::create('dpts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pilbup_id')->constrained('pilbups')->cascadeOnDelete();
            $table->string('kecamatan');
            $table->string('desa');
            $table->unsignedInteger('tps')->default(0);
            $table->unsignedInteger('dpt')->default(0);
            $table->unsignedInteger('dpph')->default(0);
            $table->unsignedInteger('dptb')->default(0);
            $table->unsignedInteger('ts')->default(0); // suara tidak sah
            $table->timestamps();
        });

        Schema::create('suara_pilbups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dpt_id')->constrained('dpts')->cascadeOnDelete();
            $table->foreignId('paslon_id')->constrained('paslons')->cascadeOnDelete();
            $table->unsignedInteger('suara')->default(0);
            $table->timestamps();
            $table->unique(['dpt_id', 'paslon_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suara_pilbups');
        Schema::dropIfExists('dpts');
        Schema::dropIfExists('paslons');
        Schema::dropIfExists('pilbups');
    }
};
