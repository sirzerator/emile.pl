<?php

namespace App\Fields\Post;

use App\Fields\ComputedField;
use App\Fields\Field;
use App\Models\Model;

class HasTranslation extends Field implements ComputedField
{
    protected bool $hasTranslation;

    public string $slug = 'has_translation';

    public static function compute(Model &$item): bool {
        return !!$item->translation;
    }

    public function __construct(array &$data) {
        $this->hasTranslation = !!data_get($data, $this->slug);
    }
}
