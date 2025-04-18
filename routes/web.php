<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleLikeController;
use App\Http\Controllers\ArticleVersionController;
use App\Http\Controllers\CKEditorUploadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/search', [SearchController::class, 'search']);

Route::post('/ckeditor/upload', [CKEditorUploadController::class, 'upload'])->name('ckeditor.upload');

Route::resource('articles', ArticleController::class);

Route::resource('categories', CategoryController::class);

Route::get('/articles/popular', [ArticleController::class, 'popular'])->name('articles.popular');

Route::post('articles/{article}/approve', [ArticleController::class, 'approve'])->name('articles.approve')->middleware('can:approve-articles');

Route::get('articles/{article}/versions', [ArticleVersionController::class, 'index'])->name('articles.versions');
Route::post('articles/{article}/versions/{version}/restore', [ArticleVersionController::class, 'restore'])->name('articles.versions.restore');

Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');
Route::patch('/comments/{comment}', [CommentController::class, 'update'])->middleware('auth')->name('comments.update');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->middleware('auth')->name('comments.destroy');

Route::post('/articles/{article}/like', [ArticleLikeController::class, 'like'])->middleware('auth')->name('articles.like');
Route::post('/articles/{article}/dislike', [ArticleLikeController::class, 'dislike'])->middleware('auth')->name('articles.dislike');

Route::get('/random', [ArticleController::class, 'random'])->name('articles.random');

Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/autocomplete', [SearchController::class, 'autocomplete'])->name('autocomplete');

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/contact-us', [ContactUsController::class, 'index'])->name('contact-us.index');
    Route::get('/contact-us/{id}', [ContactUsController::class, 'show'])->name('contact-us.show');
});

Route::get('category/{slug}', [CategoryController::class, 'showCategory'])->name('category.show');

require __DIR__.'/auth.php';
