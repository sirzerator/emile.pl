<?php

namespace App\Http\Fields;

abstract class Field
{
    public function apply($query) {
        return $query;
    }
}
