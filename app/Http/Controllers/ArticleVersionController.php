<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleVersion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleVersionController extends Controller
{
    public function index(): View
    {
        $versions = ArticleVersion::latest()->paginate(10);
        return view('admin.article_versions.index', compact('versions'));
    }

    public function destroy(ArticleVersion $version): RedirectResponse
    {
        $version->delete();

        return redirect()->back()->with('success', 'Версія статті видалена!');
    }

    public function filterArticles(Request $request): View
    {
        $search = $request->get('search');

        $versions = collect();

        if ($search) {
            $article = Article::where('title', 'LIKE', "%$search%")->first();

            if ($article) {
                $versions = $article->versions()->latest()->paginate(10);
            }
        }

        $versions = $search ? $versions : ArticleVersion::latest()->paginate(10);

        return view('admin.article_versions.index', compact('versions', 'search'));
    }

    public function show(ArticleVersion $version): View
    {
        return view('admin.article_versions.show', compact('version'));
    }

    public function restore(ArticleVersion $version): RedirectResponse
    {
        $article = $version->article;

        if (!$article) {
            abort(404, 'Стаття не знайдена для цієї версії.');
        }

        $article->update([
            'title' => $version->title,
            'slug' => $version->slug,
            'content' => $version->content,
            'description' => $version->description,
            'category_id' => $version->category_id,
            'user_id' => $version->user_id,
        ]);

        return redirect()->route('article.show', $article->slug)->with('success', 'Стаття відновлена!');
    }
}
