<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->whereIn('role', ['Editor', 'Penulis', 'Reporter', 'Redaksi'])
            ->update(['role' => 'Redaktur']);
    }

    public function down(): void
    {
        // Peran lama tidak bisa dikembalikan karena sudah digabung menjadi Redaktur.
    }
};
