<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Bersihkan catatan pembaca berita yang sudah lewat 24 jam (lihat ArticleView::prunable).
Schedule::command('model:prune')->daily();
