<?php

namespace App\Http\Controllers;

use App\Helpers\TextHelper;
use App\Models\Article;
use App\Models\ArticleVersion;
use App\Models\ArticleView;
use App\Models\Category;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $articles = Article::latest()->paginate(10);
        return view('articles.index', compact('articles'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    /**
     * @throws AuthorizationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Article::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Article::create($validated);

        return redirect()->route('articles.index')->with('success', 'Стаття створена!');
    }

    public function random()
    {
        $article = Article::inRandomOrder()->first();

        if ($article) {
            return redirect()->route('articles.show', $article);
        }

        return redirect()->route('home')->with('error', 'Немає статей.');
    }

    public function popular(): View
    {
        $articles = Article::withCount(['views', 'likes' => function ($query) {
            $query->where('is_like', true);
        }])
            ->orderByDesc('views_count')
            ->orderByDesc('likes_count')
            ->take(10) // Беремо топ-10
            ->get();

        return view('articles.popular', compact('articles'));
    }

    public function show(Article $article): View
    {
        $ip = request()->ip();

        // Записуємо перегляд тільки якщо IP не записаний сьогодні
        if (!ArticleView::where('article_id', $article->id)->where('ip', $ip)->whereDate('created_at', today())->exists()) {
            ArticleView::create([
                'article_id' => $article->id,
                'ip' => $ip,
            ]);
        }

        $article->content = TextHelper::parseInternalLinks($article->content);
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article): View
    {
        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Request $request, Article $article): RedirectResponse
    {
        $this->authorize('update', $article);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        ArticleVersion::create([
            'article_id' => $article->id,
            'title' => $article->title,
            'slug' => $article->slug,
            'content' => $article->content,
            'category_id' => $article->category_id,
            'user_id' => $article->user_id,
        ]);

        $article->update($validated);

        return redirect()->route('articles.index')->with('success', 'Стаття оновлена!');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Article $article): RedirectResponse
    {
        $this->authorize('delete', $article);

        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Стаття видалена!');
    }

    public function approve(Article $article): RedirectResponse
    {
        $article->update(['approved' => true]);

        return redirect()->route('articles.index')->with('success', 'Стаття схвалена!');
    }
}
