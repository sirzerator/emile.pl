<?php

namespace App\Fields;

use App\Fields\Field;
use App\Fields\OrderableField;

class DateField extends Field implements OrderableField
{
    public ?string $value;

    public function __construct(string $slug, array &$data) {
        $this->slug = $slug;
        $this->value = data_get($data, $this->slug);
    }

    public function order($query, $direction = 'ASC') {
        return $query->orderBy($this->slug, $direction);
    }
}
