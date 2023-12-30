<?php

namespace App\Fields;

use App\Fields\Field;
use App\Fields\FilterableField;
use App\Fields\OrderableField;

abstract class TextField extends Field implements FilterableField, OrderableField
{
    public ?string $value;

    public function __construct(string $slug, array &$data) {
        $this->slug = $slug;
        $this->value = data_get($data, $this->slug);
        unset($data[$this->slug]);
    }

    public function filter($query) {
        if ($this->value) {
            return $query->where($this->slug, 'LIKE', "%{$this->value}%");
        }

        return $query;
    }

    public function order($query, $direction = 'ASC') {
        return $query->order($this->slug, $direction);
    }
}
