<?php

namespace App\Fields;

use App\Models\Model;

interface ComputedField
{
    public static function compute(Model &$item);
}
