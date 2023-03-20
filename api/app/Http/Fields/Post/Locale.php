<?php

namespace App\Http\Fields\Post;

use App\Http\Fields\Field;

class Locale extends Field
{
    public ?string $locale;

    public function __construct(array $data) {
        $this->locale = data_get($data, 'locale');
        unset($data['locale']);
    }

    public function apply($query) {
        if ($this->locale !== null) {
            return $query->where('locale', $this->locale);
        }

        return $query;
    }
}
