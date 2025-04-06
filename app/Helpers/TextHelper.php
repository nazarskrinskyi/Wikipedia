<?php

namespace App\Helpers;

use App\Models\Article;

class TextHelper
{
    public static function parseInternalLinks(string $text): string
    {
        return preg_replace_callback('/\[\[(.*?)]]/', function ($matches) {
            $title = $matches[1];
            $article = Article::where('title', $title)->first();

            if ($article) {
                return '<a href="' . route('articles.show', $article->slug) . '">' . e($title) . '</a>';
            } else {
                return '<a href="' . route('articles.create', ['title' => $title]) . '" class="missing-article">' . e($title) . '</a>';
            }
        }, $text);
    }
}
