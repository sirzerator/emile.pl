<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Screen\AsSource;

class Post extends Model
{
    use AsSource, HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'locale',
        'intro',
        'content',
        'published_at',
    ];

    public function original() {
        return $this->belongsTo(Post::class, 'original_id');
    }

    public function translations() {
        return $this->hasMany(Post::class, 'original_id');
    }
}
