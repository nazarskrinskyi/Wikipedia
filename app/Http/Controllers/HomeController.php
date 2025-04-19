<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class HomeController
{
    public function index(): View
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();

        return view('home', compact('categories'));
    }
}
