<?php

namespace App\Providers;

use App\Models\Category;
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
        if (Schema::hasTable('categories')) {
            $categories = Category::with('children')->whereNull('parent_id')->get();
            view()->share('categories', $categories);

            $path = Request::path();
            $segments = explode('/', $path);

            $slug = $segments[1] ?? null;
            $currentRootCategory = null;

            if ($slug) {
                $category = Category::where('slug', $slug)->first();

                if ($category) {
                    while ($category->parent_id !== null) {
                        $category = $category->parent;
                    }

                    $currentRootCategory = $category;
                }
            }

            view()->share('currentCategory', $currentRootCategory);
        }
    }
}
