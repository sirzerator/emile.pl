<?php

namespace App\Fields\Post;

use App\Fields\ComputedField;
use App\Fields\Field;
use App\Fields\FilterableField;
use App\Models\Model;
use Carbon\Carbon;

class Published extends Field implements FilterableField, ComputedField
{
    protected ?bool $published;

    public string $slug = 'published';

    public function __construct(array &$data) {
        if (!isset($data[$this->slug])) {
            $this->published = null;
            return;
        }

        $this->published = filter_var(data_get($data, $this->slug), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
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
