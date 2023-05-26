<?php

namespace App\Fields\Post;

use App\Fields\Field;
use App\Fields\FilterableField;

class PublishedAt extends Field implements FilterableField
{
    public ?string $publishedAt;

    public function __construct(array &$data) {
        $this->publishedAt = data_get($data, 'published_at');
        unset($data['published_at']);
    }

    public function filter($query) {
        if ($this->publishedAt !== null) {
            return $query->where('published_at', $this->publishedAt);
        }

        return $query;
    }
}
