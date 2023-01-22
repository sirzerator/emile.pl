<?php

namespace App\Http\Filters\Category;

use App\Http\Filters\PaginationFilter;

class Pagination extends PaginationFilter
{
    public int $perPage = 10;
    public int $page = 1;
}
