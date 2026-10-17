<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['articles', 'videos'] as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            });
        }

        // Berita lama dikaitkan ke akun berdasarkan nama penulisnya.
        DB::table('users')->select('id', 'name')->get()->each(
            fn ($user) => DB::table('articles')
                ->whereNull('user_id')
                ->where('penulis_nama', $user->name)
                ->update(['user_id' => $user->id])
        );
    }

    public function down(): void
    {
        foreach (['articles', 'videos'] as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropConstrainedForeignId('user_id');
            });
        }
    }
};
