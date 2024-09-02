<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ApiBuilder extends Builder
{
    public function __call($method, $parameters) {
        $matches = [];
        if (preg_match('/whereNot(.+)/', $method, $matches)) {
            return $this->where(Str::camel($matches[1]), '!=', $parameters[0]);
        }

        return parent::__call($method, $parameters);
    }
}
