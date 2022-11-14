<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    protected static $memo;
    public static function title(string $slug) {
        if (!self::$memo) {
            self::$memo = self::asOptions();
        }

        return data_get(self::$memo, $slug, 'NA');
    }

    public static function asOptions(): array {
        return self::all()->reduce(function ($acc, $l) {
            $acc[$l->slug] = $l->name;
            return $acc;
        }, []);
    }
}
