<?php

namespace App\Policies;

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    public function view(): true
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isEditor() || $user->isAdmin() || $user->isUser();
    }

    public function update(User $user, Article $article): bool
    {
        return $user->isEditor() || $user->isAdmin() || ($user->isUser() && $article->user_id === $user->id);
    }

    public function delete(User $user, Article $article): bool
    {
        return $user->isAdmin();
    }

    public function approve(User $user): bool
    {
        return $user->isModerator();
    }
}
