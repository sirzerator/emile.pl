<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Screen\AsSource;

class Category extends Model
{
    use AsSource, HasFactory;

    protected static function booted(): void {
        static::creating(function (Category $category) {
            $category->slug = preg_replace('/\s+/', '-', mb_strtolower(strip_accents($category->title)));
        });
    }

    protected $fillable = [
        'title',
        'locale',
    ];

    public function posts() {
        return $this->belongsToMany(Post::class);
    }
}
