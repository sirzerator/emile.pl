<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Screen\AsSource;

class Category extends Model
{
    use AsSource, HasFactory;

    protected $fillable = [
        'title',
        'locale',
    ];

    public function posts() {
        return $this->belongsToMany(Post::class);
    }
}
