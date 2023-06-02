<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot as EloquentPivot;
use App\Traits\ApiModel;

class Pivot extends EloquentPivot implements ApiPivot
{
    use ApiModel;
}
