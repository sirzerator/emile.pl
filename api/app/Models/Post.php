<?php

namespace App\Models;

use App\Builders\ApiBuilder as Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Post extends Model
{
    use AsSource, Filterable, HasFactory, SoftDeletes;

    protected static function booted(): void {
        static::creating(function (Post $post) {
            $post->slug = preg_replace('/[^0-9a-zA-Z_-]/', '-', mb_strtolower(strip_accents($post->title)));
        });
    }

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

    protected array $collections = [
        'tags',
        'translations',
    ];

    protected $fillable = [
        'category_id',
        'content',
        'featured_image_url',
        'intro',
        'locale',
        'published_at',
        'title',
    ];

    protected array $items = [
        'category',
    ];

    public function newEloquentBuilder($query) {
        return new Builder($query);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

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

    public function scopeWithAvailableTranslations(Builder $query, $locale, $id) {
        return $query->whereNotLocale($locale)
                     ->notTranslated()
                     ->whereNotId($id);
    }

    public function scopeIsBookReview(Builder $query) {
        return $query->whereHas('tags', fn ($q) => $q->whereIn('tags.id', Tag::isBookReview()->pluck('id')));
    }

    public function scopeNotTranslated(Builder $query) {
        return $query->whereDoesntHave('translations');
    }
}
