<?php

namespace App\Fields\Reading;

use App\Fields\DateField;
use App\Fields\FilterableField;

class FinishedAt extends DateField implements FilterableField
{
    protected ?string $finishedAt;

    public string $slug = 'finished_at';

    public function __construct(array &$data) {
        $this->slug = 'finished_at';

        $this->finishedAt = data_get($data, 'finished_at');
    }

    public function filter($query) {
        if ($this->finishedAt !== null) {
            return $query->where('finished_at', $this->finishedAt);
        }

        return $query;
    }
}
