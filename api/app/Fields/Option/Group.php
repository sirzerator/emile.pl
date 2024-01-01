<?php

namespace App\Fields\Option;

use App\Fields\Field;
use App\Fields\FilterableField;

class Group extends Field implements FilterableField
{
    protected ?string $group;

    public string $slug = 'group';

    public function __construct(array &$data) {
        $this->group = data_get($data, $this->slug);
    }

    public function filter($query) {
        if ($this->group !== null) {
            return $query->where($this->slug, $this->group);
        }

        return $query;
    }
}
