<?php

namespace App\Fields;

abstract class Field
{
    public function apply($query) {
        return $query;
    }
}
