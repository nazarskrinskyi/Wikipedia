<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @property mixed $id
 * @property mixed $title
 * @property mixed $slug
 * @property mixed $content
 * @property mixed $category_id
 * @property mixed $user_id
 * @property mixed $description
 * @method static latest()
 * @method static create(array $validated)
 * @method static withCount(array $array)
 * @method static inRandomOrder()
 */
class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'content', 'category_id', 'user_id', 'approved', 'description'];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($article) {
            $article->slug = Str::slug($article->title);
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function versions(): HasMany
    {
        return $this->hasMany(ArticleVersion::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(ArticleLike::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(ArticleView::class);
    }
}
