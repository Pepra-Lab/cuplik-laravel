<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    /**
     * Admin mengelola semua berita, Redaktur hanya berita miliknya.
     * Member hanya boleh menambah berita, tidak mengubah atau menghapus.
     */
    public function update(User $user, Article $article): bool
    {
        return $user->isAdmin()
            || ($user->isRedaktur() && $article->user_id === $user->id);
    }

    public function delete(User $user, Article $article): bool
    {
        return $this->update($user, $article);
    }
}
