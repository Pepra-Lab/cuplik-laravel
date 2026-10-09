<?php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class ArticlePublished extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly Article $article)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Berita Terbaru: {$this->article->judul}")
            ->greeting("Halo, {$notifiable->name}!")
            ->line(Str::limit(strip_tags($this->article->lead ?: $this->article->isi), 200))
            ->action('Baca Selengkapnya', route('article.show', $this->article->slug))
            ->line('Anda menerima email ini karena terdaftar sebagai Member CuplikCom.');
    }
}
