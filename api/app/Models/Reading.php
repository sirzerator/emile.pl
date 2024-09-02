<?php

namespace App\Models;

use App\Http\Resources\ReadingResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Reading extends Model
{
    use AsSource, Filterable, HasFactory, SoftDeletes;

    protected static function booted(): void {
        static::creating(function (Reading $reading) {
            $reading->slug = preg_replace('/\s+/', '-', mb_strtolower(strip_accents($reading->title)));
        });
    }

    protected $allowedSorts = [
        'id',
        'title',
        'author',
        'finished_at',
        'created_at',
        'updated_at',
    ];

    protected $allowedFilters = [
        'title',
        'finished_at',
    ];

    protected $fillable = [
        'author',
        'cover_image_url',
        'finished_at',
        'genre_id',
        'post_id',
        'title',
    ];

    protected array $items = [
        'genre',
        'post',
    ];

    public function genre() {
        return $this->belongsTo(Genre::class);
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function getResourceInstance($includedFields = [], $excludedFields = [], $pivot = null) {
        return new ReadingResource($this, $includedFields, $excludedFields, $pivot);
    }
}
