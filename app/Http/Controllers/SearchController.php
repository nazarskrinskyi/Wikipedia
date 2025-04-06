<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function search(Request $request): View
    {
        $query = $request->input('q');
        $categoryId = $request->input('category_id');

        $results = Article::where(function ($q) use ($query) {
            $q->where('title', 'LIKE', "%$query%")
                ->orWhere('content', 'LIKE', "%$query%");
        })
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->get();

        return view('search.results', compact('results', 'query'));
    }

    public function autocomplete(Request $request): JsonResponse
    {
        $query = $request->input('q');

        $suggestions = Article::where('title', 'LIKE', "%$query%")
            ->take(5)
            ->pluck('title');

        return response()->json($suggestions);
    }
}
