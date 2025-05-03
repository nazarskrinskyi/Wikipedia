<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();

        if (Schema::hasTable('categories')) {
            $categories = Category::with('children')->whereNull('parent_id')->get();
            view()->share('categories', $categories);

            $slug = Request::segment(2);
            $currentRootCategory = null;

            if ($slug) {
                $category = Category::where('slug', $slug)->first()
                    ?? Article::where('slug', $slug)->with('category.parent')->first()?->category;

                while ($category && $category->parent_id) {
                    $category = $category->parent;
                }

                $currentRootCategory = $category;
            }

            view()->share('currentCategory', $currentRootCategory);
        }
    }
}
