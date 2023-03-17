<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Screen\AsSource;

class Tag extends Model
{
    use AsSource, HasFactory;

    protected static function booted(): void {
        static::creating(function (Tag $tag) {
            $tag->slug = preg_replace('/\s+/', '-', mb_strtolower(strip_accents($tag->title)));
        });
    }

    protected $fillable = [
        'title',
        'locale',
    ];

    public function posts() {
        return $this->hasMany(Post::class);
    }
}
