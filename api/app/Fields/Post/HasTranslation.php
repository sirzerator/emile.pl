<?php

namespace App\Fields\Post;

use App\Fields\ComputedField;
use App\Fields\Field;
use App\Models\Model;

class HasTranslation extends Field implements ComputedField
{
    protected bool $hasTranslation;

    public static function compute(Model &$item): bool {
        return !!$item->translation;
    }

    public function __construct(array &$data) {
        $this->hasTranslation = !!data_get($data, 'has_translation');
        unset($data['has_translation']);
    }
}
