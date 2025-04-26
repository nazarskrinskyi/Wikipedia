<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json(['error' => 'Search query is required.'], 400);
        }

        $articles = Article::where('title', 'LIKE', '%' . $query . '%')
            ->andWhere('approved', true)
            ->with('category:id,name,slug')
            ->get(['id', 'title', 'slug', 'category_id']);

        $categories = Category::where('name', 'LIKE', '%' . $query . '%')
            ->get(['id', 'name', 'slug']);

        return response()->json([
            'articles' => $articles->map(function ($article) {
                return [
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'category' => [
                        'name' => $article->category?->name,
                        'slug' => $article->category?->slug,
                    ]
                ];
            }),
            'categories' => $categories->map(function ($category) {
                return [
                    'name' => $category->name,
                    'slug' => $category->slug,
                ];
            }),
        ]);
    }
}
