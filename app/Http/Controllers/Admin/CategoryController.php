<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $categories = Category::with('children', 'parent')->latest()->paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('admin.category.form', compact('categories'));
    }

    /**
     * @throws AuthorizationException
     */
    public function store(Request $request): RedirectResponse
    {
        if (!Auth::user()?->is_admin) {
            $this->authorize('create', Category::class);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'from_color' => 'nullable|string',
            'to_color' => 'nullable|string',
            'preview_path' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('preview_path')) {
            $file = $request->file('preview_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);

            $validated['preview_path'] = $filename;
        }

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Категорію створено!');
    }

    public function show(Category $category): View
    {
        $category->load('children', 'parent');
        return view('admin.category.form', compact('category'));
    }

    public function showCategory(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        return view('category', compact('category'));
    }

    public function edit(Category $category): View
    {
        $categories = Category::where('id', '!=', $category->id)->get();
        return view('admin.category.form', compact('category', 'categories'));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        if (!Auth::user()?->is_admin) {
            $this->authorize('update', $category);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $category->id,
            'from_color' => 'nullable|string',
            'to_color' => 'nullable|string',
            'preview_path' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('preview_path')) {
            $file = $request->file('preview_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);

            $validated['preview_path'] = $filename;
        }

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Категорію оновлено!');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Category $category): RedirectResponse
    {
        if (!Auth::user()?->is_admin) {
            $this->authorize('delete', $category);
        }

        foreach ($category->children as $child) {
            $child->update(['parent_id' => null]);
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Категорію видалено!');
    }
}
