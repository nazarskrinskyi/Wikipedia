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

    private function getPendingCategories()
    {
        return Category::whereIn('id', function($query) {
            $query->select('category_id')
                ->from('articles')
                ->where('approved', false);
        })->get();
    }

    private function validateArticle(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'content' => 'required|string',
            'description' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'user_id' => 'nullable|exists:users,id',
        ]);
    }

    public function index(): View
    {
        $articles = Article::with('category')
            ->where('approved', false)
            ->latest()
            ->paginate(10);

        $categories = $this->getPendingCategories();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function filterArticles(Request $request): View
    {
        $category = Category::find($request->get('category_id'));
        $categories = $this->getPendingCategories();

        $articles = $category
            ? $category->articles()->where('approved', false)->latest()->paginate(10)
            : Article::with('category')->where('approved', false)->latest()->paginate(10);

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function showDetails(Article $article): View
    {
        return view('admin.articles.show', compact('article'));
    }

    public function create(): View
    {
        $categories = Category::whereNotNull('parent_id')->get();
        return view('articles.form', compact('categories'));
    }

    /**
     * @throws AuthorizationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Article::class);

        $article = Article::create($this->validateArticle($request));

        return redirect()->route('article.show', $article->slug)->with('success', 'Стаття створена!');
    }

    public function random(): RedirectResponse
    {
        $article = Article::inRandomOrder()->first();

        return $article
            ? redirect()->route('articles.show', $article)
            : redirect()->route('home')->with('error', 'Немає статей.');
    }

    public function popular(): View
    {
        $articles = Article::withCount([
            'views',
            'likes' => fn($query) => $query->where('is_like', true)
        ])
            ->orderByDesc('views_count')
            ->orderByDesc('likes_count')
            ->take(10)
            ->get();

        return view('articles.popular', compact('articles'));
    }

    public function show(string $slug): View
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        $ip = request()->ip();
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
        $categories = Category::whereNotNull('parent_id')->get();
        return view('articles.form', compact('article', 'categories'));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Request $request, Article $article): RedirectResponse
    {
        $this->authorize('update', $article);

        $validated = $this->validateArticle($request);

        if ($article->isDirty($validated)) {
            ArticleVersion::create($article->only([
                'id as article_id', 'title', 'slug', 'content', 'description', 'category_id', 'user_id'
            ]));
        }

        $article->update($validated);

        return redirect()->route('article.show', $article->slug)->with('success', 'Стаття оновлена!');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Article $article): RedirectResponse
    {
        $this->authorize('delete', $article);

        $article->delete();

        return redirect()->back()->with('success', 'Стаття видалена!');
    }

    public function approve(Article $article): RedirectResponse
    {
        $article->update(['approved' => true]);

        return redirect()->route('article.show', ['slug' => $article->slug])->with('success', 'Стаття схвалена!');
    }
}
