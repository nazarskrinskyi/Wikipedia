<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleVersion;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ArticleVersionController extends Controller
{
    public function index(): View
    {
        $versions = ArticleVersion::latest()->paginate(10);
        return view('admin.article_versions.index', compact('versions'));
    }

    public function show(string $slug): View
    {
        $versions = ArticleVersion::where('slug', $slug)->latest()->paginate(10);
        return view('admin.articles_versions.index', compact('slug', 'versions'));
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
