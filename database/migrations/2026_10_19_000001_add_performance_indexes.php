<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->index(['status', 'tanggal'], 'articles_status_tanggal_idx');
            $table->index(['status', 'dibaca'], 'articles_status_dibaca_idx');
            $table->index(['category_id', 'status', 'tanggal'], 'articles_cat_status_tanggal_idx');
            $table->index(['user_id', 'status'], 'articles_user_status_idx');
        });

        Schema::table('article_tag', function (Blueprint $table) {
            $table->index('tag_id', 'article_tag_tag_id_idx');
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->index(['status', 'tanggal'], 'videos_status_tanggal_idx');
        });

        Schema::table('iklan_gambars', function (Blueprint $table) {
            $table->index(['status', 'posisi'], 'iklan_gambars_status_posisi_idx');
        });

        Schema::table('iklan_baris', function (Blueprint $table) {
            $table->index(['status', 'tanggal'], 'iklan_baris_status_tanggal_idx');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->index(['article_id', 'status'], 'comments_article_status_idx');
        });

        Schema::table('curhats', function (Blueprint $table) {
            $table->index(['status', 'created_at'], 'curhats_status_created_idx');
        });
    }

    public function down(): void
    {
        Schema::table('curhats', function (Blueprint $table) {
            $table->dropIndex('curhats_status_created_idx');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex('comments_article_status_idx');
        });

        Schema::table('iklan_baris', function (Blueprint $table) {
            $table->dropIndex('iklan_baris_status_tanggal_idx');
        });

        Schema::table('iklan_gambars', function (Blueprint $table) {
            $table->dropIndex('iklan_gambars_status_posisi_idx');
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->dropIndex('videos_status_tanggal_idx');
        });

        Schema::table('article_tag', function (Blueprint $table) {
            $table->dropIndex('article_tag_tag_id_idx');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->dropIndex('articles_status_tanggal_idx');
            $table->dropIndex('articles_status_dibaca_idx');
            $table->dropIndex('articles_cat_status_tanggal_idx');
            $table->dropIndex('articles_user_status_idx');
        });
    }
};
