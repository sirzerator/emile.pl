<?php

namespace App\Fields;

interface OrderableField
{
    public function order($query);
}
