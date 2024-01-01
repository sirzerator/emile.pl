<?php

namespace App\Fields;

class PaginationField extends Field implements FilterableField
{
    public int $perPage = 10;
    public int $page = 1;

    public function __construct(array &$data) {
        $perPage = data_get($data, 'per_page');
        if ($perPage === '*') {
            $perPage = -1;
        }
        if (!empty($perPage) && is_numeric($perPage)) {
            $this->perPage = (int) $perPage;
        }

        $page = data_get($data, 'page');

        if (!empty($page) && is_numeric($page)) {
            $this->page = (int) $page;
        }
    }

    public function filter($query) {
        return $query
            ->take($this->perPage)
            ->skip($this->perPage * ($this->page - 1));
    }
}
