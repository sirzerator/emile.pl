<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseModel extends Model
{
    public function __call($method, $parameters) {
        $matches = [];
        if (preg_match('/where(Not)(.+)/', $method, $matches)) {
            return parent::__call('where', [Str::camel($matches[2]), '!=', $parameters[0]]);
        }

        return parent::__call($method, $parameters);
    }
}
