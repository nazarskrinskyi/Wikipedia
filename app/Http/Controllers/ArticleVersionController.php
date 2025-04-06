<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleVersion;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ArticleVersionController extends Controller
{
    public function index(Article $article): View
    {
        $versions = ArticleVersion::where('article_id', $article->id)->latest()->get();
        return view('articles.versions', compact('article', 'versions'));
    }

    public function restore(Article $article, ArticleVersion $version): RedirectResponse
    {
        $article->update([
            'title' => $version->title,
            'slug' => $version->slug,
            'content' => $version->content,
            'category_id' => $version->category_id,
            'user_id' => $version->user_id,
        ]);

        return redirect()->route('articles.index')->with('success', 'Стаття відновлена!');
    }
}
