<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @method static create(array $validated)
 * @method static where(string $string, string $string1, mixed $id)
 * @property mixed $id
 * @property mixed $children
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'parent_id'];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
