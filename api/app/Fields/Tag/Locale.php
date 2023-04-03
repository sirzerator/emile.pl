<?php

namespace App\Fields\Tag;

use App\Fields\Field;

class Locale extends Field
{
    public ?string $locale;

    public function __construct(array &$params) {
        $this->locale = data_get($params, 'locale');
        unset($params['locale']);
    }

    public function apply($query) {
        if ($this->locale !== null) {
            return $query->where('locale', $this->locale);
        }

        return $query;
    }
}
