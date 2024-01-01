<?php

namespace App\Fields\Post;

use App\Fields\Field;
use App\Fields\FilterableField;

class PublishedAt extends Field implements FilterableField
{
    protected ?string $publishedAt;

    public string $slug = 'published_at';

    public function __construct(array &$data) {
        $this->publishedAt = data_get($data, $this->slug);
    }

    public function filter($query) {
        if ($this->publishedAt !== null) {
            return $query->where($this->slug, $this->publishedAt);
        }

        return $query;
    }
}
