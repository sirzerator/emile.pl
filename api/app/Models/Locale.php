<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    public static function asOptions(): array {
        return self::all()->reduce(function ($acc, $l) {
            $acc[$l->slug] = $l->name;
            return $acc;
        }, []);
    }
}
