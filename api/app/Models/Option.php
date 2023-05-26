<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'group',
        'locale',
        'slug',
        'value',
    ];
}
