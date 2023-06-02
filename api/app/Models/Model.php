<?php

namespace App\Models;

use App\Traits\ApiModel;
use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel
{
    use ApiModel;
}
