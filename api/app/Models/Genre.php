<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Genre extends Model
{
    use AsSource, Filterable, HasFactory;

    protected $allowedSorts = [
        'id',
        'title',
        'locale',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'locale',
    ];

    public function readings() {
        return $this->belongsToMany(Reading::class);
    }
}
