<?php

namespace App\Http\Fields\Post;

use App\Http\Fields\PaginationField;

class Pagination extends PaginationField
{
    public int $perPage = 10;
    public int $page = 1;
}
