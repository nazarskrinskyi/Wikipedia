<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\CategoryController as CategoryCatalogController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleLikeController;
use App\Http\Controllers\ArticleVersionController;
use App\Http\Controllers\CKEditorUploadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
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

Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');
Route::patch('/comments/{comment}', [CommentController::class, 'update'])->middleware('auth')->name('comments.update');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->middleware('auth')->name('comments.destroy');

Route::post('/articles/{article}/like', [ArticleLikeController::class, 'like'])->middleware('auth')->name('articles.like');
Route::post('/articles/{article}/dislike', [ArticleLikeController::class, 'dislike'])->middleware('auth')->name('articles.dislike');

Route::get('/random', [ArticleController::class, 'random'])->name('articles.random');

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/contact-us', [ContactUsController::class, 'index'])->name('contact-us.index');
    Route::get('/contact-us/{id}', [ContactUsController::class, 'show'])->name('contact-us.show');

    Route::get('articles-versions/', [ArticleVersionController::class, 'index'])->name('articles-versions.index');
    Route::get('articles-versions/filter', [ArticleVersionController::class, 'filterArticles'])->name('articles-versions.filter');
    Route::get('articles-versions/{version}', [ArticleVersionController::class, 'show'])->name('articles-versions.show');
    Route::post('articles-versions/{version}', [ArticleVersionController::class, 'restore'])->name('articles-versions.restore');

    Route::get('articles-approve/', [ArticleController::class, 'index'])->name('articles-approve.index');
    Route::get('articles-approve/filter', [ArticleController::class, 'filterArticles'])->name('articles-approve.filter');
    Route::get('articles-approve/{article}', [ArticleController::class, 'showDetails'])->name('articles-approve.show');
    Route::post('articles-approve/{article}', [ArticleController::class, 'approve'])->name('articles-approve.approve');

    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
});

Route::get('category/{slug}', [CategoryCatalogController::class, 'index'])->name('category.index');

Route::get('header-category/{slug}', [CategoryCatalogController::class, 'show'])->name('category.show');

Route::get('article/{slug}', [ArticleController::class, 'show'])->name('article.show');

require __DIR__.'/auth.php';
