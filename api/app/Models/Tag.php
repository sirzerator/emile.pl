<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Screen\AsSource;

class Tag extends Model
{
    use AsSource, HasFactory;

    protected $fillable = [
        'title',
        'locale',
    ];

    public function posts() {
        return $this->hasMany(Post::class);
    }
}
