<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 * @method static where(string $string, mixed $id)
 */
class ArticleView extends Model
{
    use HasFactory;

    protected $fillable = ['article_id', 'ip'];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
