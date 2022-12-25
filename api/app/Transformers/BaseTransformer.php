<?php

namespace App\Transformers;

class BaseTransformer
{
    public function transform($item, $options = []) {
        return $item;
    }
}
