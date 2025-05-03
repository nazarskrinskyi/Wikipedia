<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        return view('category.show', compact('category'));
    }

    public function index(string $slug): View|RedirectResponse
    {
        $category = Category::where('slug', $slug)->with('articles')->firstOrFail();

        if ($category->parent === null) {
            return redirect()->route('category.show', $category->slug);
        }

        if ($category->children->count() === 0) {
            return redirect()->route('category.index', $category->parent->slug);
        }

        $parentCategories = $category->getParentHierarchy();

        return view('category.index', compact('category', 'parentCategories'));
    }
}
