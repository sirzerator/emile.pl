<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Contact extends Model
{
    use AsSource, Filterable, HasFactory;

    protected $allowedSorts = [
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = [
        'name',
        'email',
        'locale',
        'message',
    ];
}
