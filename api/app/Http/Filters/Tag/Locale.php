<?php

namespace App\Http\Filters\Tag;

use App\Http\Filters\Filter;

class Locale extends Filter
{
    public ?string $locale;

    public function __construct(array $data) {
        $this->locale = data_get($data, 'locale');
    }

    public function apply($query) {
        if ($this->locale !== null) {
            return $query->where('locale', $this->locale);
        }

        return $query;
    }
}
