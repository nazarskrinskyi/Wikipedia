<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 * @method static where(string $string, mixed $id)
 * @property mixed $title
 * @property mixed $slug
 * @property mixed $content
 * @property mixed $category_id
 * @property mixed $user_id
 */
class ArticleVersion extends Model
{
    use HasFactory;

    protected $fillable = ['article_id', 'title', 'slug', 'content', 'category_id', 'user_id'];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
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
