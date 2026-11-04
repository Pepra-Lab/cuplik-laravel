<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Penyesuaian skema baru supaya data situs lama (cuplkcom_portal) bisa masuk
 * tanpa kehilangan informasi. Semua perubahan bersifat menambah (additive):
 * tidak ada kolom atau tabel yang sudah ada diubah atau dihapus.
 */
return new class extends Migration
{
    public function up(): void
    {
        // ---------------------------------------------------------------
        // 1. Berita: sumber foto, dan id lama (untuk redirect /read/{id}/...)
        // ---------------------------------------------------------------
        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasColumn('articles', 'sumber_foto')) {
                $table->string('sumber_foto', 150)->nullable()->after('caption_foto');
            }
            if (!Schema::hasColumn('articles', 'sumber_foto_2')) {
                $table->string('sumber_foto_2', 150)->nullable()->after('caption_foto_2');
            }
            if (!Schema::hasColumn('articles', 'legacy_id')) {
                // id_berita di situs lama. Dipakai untuk redirect 301 URL lama.
                $table->unsignedBigInteger('legacy_id')->nullable()->unique();
            }
        });

        // ---------------------------------------------------------------
        // 2. Gambar tambahan berita (padanan tabel gambar_berita lama).
        //    Tidak dibatasi 2 foto seperti foto/foto_2.
        // ---------------------------------------------------------------
        if (!Schema::hasTable('article_images')) {
            Schema::create('article_images', function (Blueprint $table) {
                $table->id();
                $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
                $table->string('foto');
                $table->string('sumber', 150)->nullable();
                $table->text('keterangan')->nullable();
                $table->string('tampil')->default('Ya'); // 'Ya' / 'Tidak'
                $table->unsignedInteger('urutan')->default(0);
                $table->unsignedBigInteger('legacy_id')->nullable()->unique();
                $table->timestamps();
            });
        }

        // ---------------------------------------------------------------
        // 3. Tabel pemetaan id lama -> id baru. Dipakai skrip impor supaya
        //    bisa dijalankan berulang tanpa membuat data dobel.
        // ---------------------------------------------------------------
        if (!Schema::hasTable('legacy_map')) {
            Schema::create('legacy_map', function (Blueprint $table) {
                $table->id();
                $table->string('tabel', 40);        // contoh: menu, tag, user, member
                $table->string('kode_lama', 100);   // id/kunci di database lama
                $table->unsignedBigInteger('id_baru');
                $table->timestamps();
                $table->unique(['tabel', 'kode_lama']);
            });
        }

        // ---------------------------------------------------------------
        // 4. Real count / Pilkada: lengkapi kolom yang ada di tabel lama
        // ---------------------------------------------------------------
        Schema::table('pilbups', function (Blueprint $table) {
            if (!Schema::hasColumn('pilbups', 'gambar')) {
                $table->string('gambar')->nullable()->after('judul');
            }
            if (!Schema::hasColumn('pilbups', 'jumlah_pps')) {
                $table->unsignedInteger('jumlah_pps')->default(0)->after('status');
            }
            if (!Schema::hasColumn('pilbups', 'kode_lama')) {
                $table->string('kode_lama', 5)->nullable()->unique();
            }
        });

        Schema::table('paslons', function (Blueprint $table) {
            if (!Schema::hasColumn('paslons', 'inisial')) {
                $table->string('inisial', 100)->nullable()->after('nama');
            }
        });

        Schema::table('dpts', function (Blueprint $table) {
            if (!Schema::hasColumn('dpts', 'kode_kel')) {
                // id_kel lama (kode wilayah 10 digit)
                $table->string('kode_kel', 10)->nullable()->after('desa');
            }
        });

        // Rekap suara per TPS (di tabel lama: hasilsuara). Tabel baru
        // suara_pilbups hanya menyimpan total per desa, jadi rincian per TPS,
        // siapa yang menginput, dan kapan, perlu tempat sendiri.
        if (!Schema::hasTable('hasil_suaras')) {
            Schema::create('hasil_suaras', function (Blueprint $table) {
                $table->id();
                $table->foreignId('dpt_id')->constrained('dpts')->cascadeOnDelete();
                $table->unsignedInteger('tps');
                $table->unsignedInteger('tidak_sah')->default(0);
                $table->unsignedInteger('dpt')->default(0);
                $table->unsignedInteger('dpph')->default(0);
                $table->unsignedInteger('dptb')->default(0);
                $table->string('diinput_oleh')->nullable();
                $table->dateTime('diinput_pada')->nullable();
                $table->timestamps();
                $table->unique(['dpt_id', 'tps']);
            });
        }

        if (!Schema::hasTable('hasil_suara_paslons')) {
            Schema::create('hasil_suara_paslons', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hasil_suara_id')->constrained('hasil_suaras')->cascadeOnDelete();
                $table->foreignId('paslon_id')->constrained('paslons')->cascadeOnDelete();
                $table->unsignedInteger('suara')->default(0);
                $table->timestamps();
                $table->unique(['hasil_suara_id', 'paslon_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_suara_paslons');
        Schema::dropIfExists('hasil_suaras');

        Schema::table('dpts', function (Blueprint $table) {
            if (Schema::hasColumn('dpts', 'kode_kel')) {
                $table->dropColumn('kode_kel');
            }
        });

        Schema::table('paslons', function (Blueprint $table) {
            if (Schema::hasColumn('paslons', 'inisial')) {
                $table->dropColumn('inisial');
            }
        });

        Schema::table('pilbups', function (Blueprint $table) {
            if (Schema::hasColumn('pilbups', 'kode_lama')) {
                $table->dropUnique(['kode_lama']);
                $table->dropColumn('kode_lama');
            }
            foreach (['jumlah_pps', 'gambar'] as $col) {
                if (Schema::hasColumn('pilbups', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::dropIfExists('legacy_map');
        Schema::dropIfExists('article_images');

        Schema::table('articles', function (Blueprint $table) {
            if (Schema::hasColumn('articles', 'legacy_id')) {
                $table->dropUnique(['legacy_id']);
                $table->dropColumn('legacy_id');
            }
            foreach (['sumber_foto_2', 'sumber_foto'] as $col) {
                if (Schema::hasColumn('articles', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
