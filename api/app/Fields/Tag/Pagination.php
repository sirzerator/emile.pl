<?php

namespace App\Fields\Tag;

use App\Fields\FilterableField;
use App\Fields\PaginationField;

class Pagination extends PaginationField
{
    public int $perPage = 10;
    public int $page = 1;
}
