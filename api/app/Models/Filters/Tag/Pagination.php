<?php

namespace App\Models\Filters\Tag;

use App\Http\Filters\PaginationFilter;

class Pagination extends PaginationFilter
{
    public int $perPage = 10;
    public int $page = 1;
}
