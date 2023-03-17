<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Post extends Model
{
    use AsSource, Filterable, HasFactory, SoftDeletes;

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

    protected $fillable = [
        'content',
        'featured_image_url',
        'intro',
        'locale',
        'published_at',
        'slug',
        'title',
    ];

    public function translation() {
        return $this->hasOneThrough(
            Post::class,
            Pivots\PostTranslation::class,
            'post_id',
            'id',
            'id',
            'translation_id',
        )->select('posts.*', 'post_is_source');
    }

    public function translations() {
        return $this->belongsToMany(Post::class, 'post_translation', 'post_id', 'translation_id')
                    ->using(Pivots\PostTranslation::class)
                    ->withPivot('post_is_source')
                    ->withTimestamps();
    }
}
