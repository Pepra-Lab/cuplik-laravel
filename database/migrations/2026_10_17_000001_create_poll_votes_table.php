<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Mencatat setiap suara yang masuk per polling, supaya satu "identitas"
 * pengunjung (token di cookie, lihat PollController) cuma bisa vote sekali
 * per polling — unique constraint (poll_id, voter_token) mencegah bot
 * nge-spam increment suara lewat request berulang.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('poll_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poll_id')->constrained('polls')->cascadeOnDelete();
            $table->foreignId('poll_option_id')->constrained('poll_options')->cascadeOnDelete();
            $table->string('voter_token', 64);
            $table->string('ip_hash', 64)->nullable();
            $table->timestamps();

            $table->unique(['poll_id', 'voter_token']);
            $table->index(['poll_id', 'ip_hash']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poll_votes');
    }
};
