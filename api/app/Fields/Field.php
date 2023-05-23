<?php

namespace App\Fields;

abstract class Field
{
    abstract public function __construct(array &$data);
}
