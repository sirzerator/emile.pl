<?php

namespace App\Fields\Option;

use App\Fields\Field;
use App\Fields\FilterableField;

class Locale extends Field implements FilterableField
{
    protected ?string $locale;

    public string $slug = 'locale';

    public function __construct(array &$data) {
        $this->locale = data_get($data, $this->slug);
    }

    public function filter($query) {
        if ($this->locale !== null) {
            return $query->where($this->slug, $this->locale);
        }

        return $query;
    }
}
