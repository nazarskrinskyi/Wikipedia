<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    public function showCategory(string $slug): View|RedirectResponse
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        if ($category->parent === null) {
            return redirect()->route('home.index');
        }

        $parentCategories = $category->getParentHierarchy();

        return view('category.index', compact('category', 'parentCategories'));
    }
}
