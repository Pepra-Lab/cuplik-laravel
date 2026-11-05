<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom profil inti yang dulu ada di tabel `user` database lama
     * (nm_inisial, tempat_lahir, tgl_lahir, telp, almt_asal/almt_domisili),
     * disamakan ke tabel `users` yang baru. Berlaku untuk semua role
     * (Super Admin, Admin, Redaktur, Member) — bukan tabel terpisah.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nm_inisial', 10)->nullable()->after('name');
            $table->string('tempat_lahir', 50)->nullable()->after('email');
            $table->date('tgl_lahir')->nullable()->after('tempat_lahir');
            $table->string('telp', 20)->nullable()->after('tgl_lahir');
            $table->string('alamat', 300)->nullable()->after('telp');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nm_inisial', 'tempat_lahir', 'tgl_lahir', 'telp', 'alamat']);
        });
    }
};
