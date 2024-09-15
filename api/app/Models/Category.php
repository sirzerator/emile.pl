<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Category extends Model
{
    use AsSource, Filterable, HasFactory;

    protected static function booted(): void {
        static::creating(function (Category $category) {
            $category->slug = preg_replace('/[^0-9a-zA-Z_-]/', '-', mb_strtolower(strip_accents($category->title)));
        });
    }

    protected $allowedSorts = [
        'id',
        'title',
        'locale',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'locale',
    ];

    public function posts() {
        return $this->belongsToMany(Post::class);
    }
}
