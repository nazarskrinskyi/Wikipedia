<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $categories = Category::with('children', 'parent')->latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('categories.create', compact('categories'));
    }

    /**
     * @throws AuthorizationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Category::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Категорію створено!');
    }

    public function show(Category $category): View
    {
        $category->load('children', 'parent');
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        $categories = Category::where('id', '!=', $category->id)->get();
        return view('categories.edit', compact('category', 'categories'));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $this->authorize('update', $category);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $category->id,
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Категорію оновлено!');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Category $category): RedirectResponse
    {
        $this->authorize('delete', $category);

        foreach ($category->children as $child) {
            $child->update(['parent_id' => null]);
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Категорію видалено!');
    }
}
