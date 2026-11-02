<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\InfoPage;
use Illuminate\Console\Command;

/**
 * Jalankan SEKALI setelah import database lama.
 *
 * Import lewat SQL melewati mutator setIsiAttribute()/setKontenAttribute(), jadi HTML lama
 * (tag <font>, atribut onclick, dsb) masuk apa adanya. Command ini melewatkan ulang semua
 * isi berita & halaman info lewat HtmlSanitizer milik proyek. Memakai saveQuietly() agar
 * ArticleObserver tidak mengirim notifikasi email ke member, dan timestamps tidak diubah.
 *
 * Simpan sebagai app/Console/Commands/LegacySanitize.php (Laravel 11+ otomatis mendaftarkannya).
 */
class LegacySanitize extends Command
{
    protected $signature = 'legacy:sanitize';
    protected $description = 'Sanitasi ulang HTML berita & halaman info hasil import database lama';

    public function handle(): int
    {
        $changed = 0;

        Article::query()->chunkById(200, function ($articles) use (&$changed) {
            foreach ($articles as $article) {
                $article->timestamps = false;
                $article->isi = $article->getRawOriginal('isi'); // memicu mutator sanitizer
                if ($article->isDirty('isi')) {
                    $article->saveQuietly();
                    $changed++;
                }
            }
        });
        $this->info("Berita yang berubah setelah disanitasi: {$changed}");

        InfoPage::query()->each(function ($page) {
            $page->timestamps = false;
            $page->konten = $page->getRawOriginal('konten');
            $page->saveQuietly();
        });
        $this->info('Halaman info selesai.');

        return self::SUCCESS;
    }
}
