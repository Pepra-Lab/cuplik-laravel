<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Video;

class VideoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isRedaktur();
    }

    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    public function update(User $user, Video $video): bool
    {
        return $user->isAdmin()
            || ($user->isRedaktur() && $video->user_id === $user->id);
    }

    public function delete(User $user, Video $video): bool
    {
        return $this->update($user, $video);
    }
}
