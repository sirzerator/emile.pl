<?php

namespace App\Fields\Option;

use App\Fields\Field;
use App\Fields\FilterableField;

class Group extends Field implements FilterableField
{
    public ?string $group;

    public function __construct(array &$data) {
        $this->group = data_get($data, 'group');
        unset($data['group']);
    }

    public function filter($query) {
        if ($this->group !== null) {
            return $query->where('group', $this->group);
        }

        return $query;
    }
}
