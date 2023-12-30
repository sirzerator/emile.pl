<?php

namespace App\Fields\Reading;

use App\Fields\TextField;

class Author extends TextField
{
    public function __construct(array &$data) {
        parent::__construct('author', $data);
    }
}
