<?php

namespace App\Fields\Reading;

use App\Fields\TextField;

class Title extends TextField
{
    public function __construct(array &$data) {
        parent::__construct('title', $data);
    }
}
