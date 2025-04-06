<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate(['content' => 'required|string']);

        $article->comments()->create($validated);

        return back()->with('success', 'Коментар додано!');
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Request $request, Comment $comment): RedirectResponse
    {
        $this->authorize('update-comment', $comment);

        $validated = $request->validate(['content' => 'required|string']);
        $comment->update($validated);

        return back()->with('success', 'Коментар оновлено!');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete-comment', $comment);

        $comment->delete();
        return back()->with('success', 'Коментар видалено!');
    }
}
