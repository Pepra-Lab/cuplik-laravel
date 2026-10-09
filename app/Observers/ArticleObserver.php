<?php

namespace App\Observers;

use App\Models\Article;
use App\Models\User;
use App\Notifications\ArticlePublished;
use Illuminate\Support\Facades\Notification;

class ArticleObserver
{
    public function created(Article $article): void
    {
        if ($article->status === 'Terbit') {
            $this->notifyMembers($article);
        }
    }

    public function updated(Article $article): void
    {
        if ($article->wasChanged('status') && $article->status === 'Terbit') {
            $this->notifyMembers($article);
        }
    }

    private function notifyMembers(Article $article): void
    {
        $members = User::where('role', User::ROLE_MEMBER)
            ->where('status', User::STATUS_ACTIVE)
            ->get();

        Notification::send($members, new ArticlePublished($article));
    }
}
