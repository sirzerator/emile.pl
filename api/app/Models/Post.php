<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Screen\AsSource;

class Post extends Model
{
    use AsSource, HasFactory, SoftDeletes;

    protected $fillable = [
        'content',
        'featured_image_url',
        'intro',
        'locale',
        'published_at',
        'slug',
        'title',
    ];

    public function original() {
        return $this->belongsTo(Post::class, 'original_id');
    }

    public function translations() {
        return $this->hasMany(Post::class, 'original_id');
    }
}
