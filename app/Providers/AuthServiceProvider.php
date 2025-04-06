<?php

namespace App\Providers;

use App\Policies\ArticlePolicy;
use App\Policies\CommentPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('approve-articles', [ArticlePolicy::class, 'approve']);
        Gate::define('update-comment', [CommentPolicy::class, 'update']);
        Gate::define('delete-comment', [CommentPolicy::class, 'delete']);
    }
}
