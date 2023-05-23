<?php

namespace App\Fields;

interface FilterableField
{
    public function filter($query);
}
