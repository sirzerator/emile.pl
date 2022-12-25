<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

class RepositoryCollection
{
    public function __construct(
        public readonly Collection $items,
        public readonly int $total
    ) {
    }
}
