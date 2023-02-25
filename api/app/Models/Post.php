<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Post extends Model
{
    use AsSource, Filterable, HasFactory, SoftDeletes;

    protected $fillable = [
        'content',
        'featured_image_url',
        'intro',
        'locale',
        'published_at',
        'slug',
        'title',
    ];

    protected $allowedSorts = [
        'id',
        'title',
        'locale',
        'published_at',
        'created_at',
        'updated_at',
    ];

    protected $allowedFilters = [
        'title',
        'locale',
        'published_at',
    ];

    public function original() {
        return $this->belongsTo(Post::class, 'original_id');
    }

    public function translations() {
        return $this->hasMany(Post::class, 'original_id');
    }
}
