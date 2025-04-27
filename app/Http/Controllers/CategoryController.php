<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        return view('category.show', compact('category'));
    }

    public function index(string $slug): View
    {
        $category = Category::where('slug', $slug)->with('articles')->firstOrFail();

        if ($category->parent === null) {
            abort(404);
        }

        $parentCategories = $category->getParentHierarchy();

        return view('category.index', compact('category', 'parentCategories'));
    }
}
