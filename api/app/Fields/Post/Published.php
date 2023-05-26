<?php

namespace App\Fields\Post;

use App\Fields\ComputedField;
use App\Fields\Field;
use App\Fields\FilterableField;
use App\Models\Model;
use Carbon\Carbon;

class Published extends Field implements FilterableField, ComputedField
{
    public ?bool $published;

    public function __construct(array &$data) {
        if (!isset($data['published'])) {
            $this->published = null;
            return;
        }

        $this->published = filter_var(data_get($data, 'published'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        unset($data['published']);
    }

    public function filter($query) {
        if ($this->published !== null) {
            if ($this->published === true) {
                return $query->where('published_at', '<', Carbon::now());
            }

            if ($this->published === false) {
                return $query->where(fn ($q) => $q->where('published_at', '>=', Carbon::now())->orWhereNull('published_at'));
            }
        }

        return $query;
    }

    public static function compute(Model &$item) {
        return Carbon::parse($item->published_at)->isPast();
    }
}
