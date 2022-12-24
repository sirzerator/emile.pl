<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\BaseRequest;

class CreateRequest extends BaseRequest
{
    public function rules() {
        return [
            'category.title' => 'required',
            'category.slug' => 'required',
        ];
    }
}
