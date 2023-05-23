<?php

namespace App\Fields\Post;

use App\Fields\Field;
use App\Fields\FilterableField;

class Locale extends Field implements FilterableField
{
    public ?string $locale;

    public function __construct(array &$data) {
        $this->locale = data_get($data, 'locale');
        unset($data['locale']);
    }

    public function filter($query) {
        if ($this->locale !== null) {
            return $query->where('locale', $this->locale);
        }

        return $query;
    }
}
