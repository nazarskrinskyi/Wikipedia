<?php

use App\Models\Category;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('category', function (BreadcrumbTrail $trail, Category $category) {
    $ancestors = [];

    $original = $category;

    while ($category->parent) {
        $category = $category->parent;
        $ancestors[] = $category;
    }

    foreach (array_unique(array_reverse($ancestors)) as $ancestor) {
        $trail->push($ancestor->name, route('category.index', $ancestor->slug));
    }

    $trail->push($original->name, route('category.index', $original->slug) . '#' . $original->slug);
});

Breadcrumbs::for('article', function (BreadcrumbTrail $trail, $article) {
    $trail->parent('category', $article->category);
    $trail->push($article->title, route('article.show', $article->slug));
});
