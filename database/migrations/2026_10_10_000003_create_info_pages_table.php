<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Halaman statis portal (disclaimer, pedoman, redaksi, iklan) yang
     * sebelumnya ditulis langsung di blade, sekarang dikelola lewat CMS.
     */
    public function up(): void
    {
        Schema::create('info_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('badge')->nullable();
            $table->string('judul');
            $table->string('subjudul')->nullable();
            $table->longText('konten');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('info_pages');
    }
};
