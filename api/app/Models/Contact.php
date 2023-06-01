<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Screen\AsSource;

class Contact extends Model
{
    use AsSource, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'locale',
        'message',
    ];
}
