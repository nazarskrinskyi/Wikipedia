<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 * @method static where(string $string, mixed $id)
 * @method static latest()
 * @method static select(string $string)
 * @property mixed $title
 * @property mixed $slug
 * @property mixed $content
 * @property mixed $category_id
 * @property mixed $user_id
 * @property mixed $description
 */
class ArticleVersion extends Model
{
    use HasFactory;

    protected $fillable = ['article_id', 'title', 'slug', 'content', 'category_id', 'user_id', 'description'];

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

    public function toArray()
    {
        return [
            'id' => $this->id,
            'article_id' => $this->article_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
