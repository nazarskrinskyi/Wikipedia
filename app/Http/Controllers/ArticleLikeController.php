<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleLike;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ArticleLikeController extends Controller
{
    public function like(Article $article): RedirectResponse
    {
        return $this->handleLike($article, true);
    }

    public function dislike(Article $article): RedirectResponse
    {
        return $this->handleLike($article, false);
    }

    private function handleLike(Article $article, bool $is_like)
    {
        $user = Auth::user();

        $like = ArticleLike::where('article_id', $article->id)->where('user_id', $user->id)->first();

        if ($like) {
            $like->is_like === $is_like ?
                $like->delete() : // Якщо повторний клік на ту ж кнопку — видаляємо лайк/дизлайк
                $like->update(['is_like' => $is_like]); // Зміна лайка на дизлайк або навпаки
        } else {
            ArticleLike::create([
                'article_id' => $article->id,
                'user_id' => $user->id,
                'is_like' => $is_like,
            ]);
        }

        return back();
    }
}
