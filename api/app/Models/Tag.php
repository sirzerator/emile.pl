<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Tag extends Model
{
    use AsSource, Filterable, HasFactory;

    protected static function booted(): void {
        static::creating(function (Tag $tag) {
            $tag->slug = preg_replace('/\s+/', '-', mb_strtolower(strip_accents($tag->title)));
        });
    }

    protected $allowedSorts = [
        'id',
        'title',
        'locale',
        'created_at',
        'updated_at',
    ];

    protected $allowedFilters = [
        'title',
        'locale',
    ];

    protected $fillable = [
        'title',
        'locale',
    ];

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function scopeIsBookReview() {
        return $this->where(
            fn ($f) => $f
                ->where('slug', 'critique-litteraire')
                ->orWhere('slug', 'book-review')
        );
    }
}
