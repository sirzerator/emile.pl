<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Screen\AsSource;

class Genre extends Model
{
    use AsSource, HasFactory;

    protected $fillable = [
        'title',
        'locale',
    ];

    public function readings() {
        return $this->belongsToMany(Reading::class);
    }
}
