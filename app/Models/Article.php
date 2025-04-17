<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * @property mixed $id
 * @property mixed $title
 * @property mixed $slug
 * @property mixed $content
 * @property mixed $category_id
 * @property mixed $user_id
 * @method static latest()
 * @method static create(array $validated)
 * @method comments()
 * @method static withCount(array $array)
 * @method static inRandomOrder()
 */
class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'preview_path', 'content', 'category_id', 'user_id', 'approved'];

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
}
