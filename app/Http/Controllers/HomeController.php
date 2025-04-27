<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController
{
    public function index(): View
    {
        return view('home');
    }
}
