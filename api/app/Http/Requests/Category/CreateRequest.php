<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\ApiRequest;

class CreateRequest extends ApiRequest
{
    public function rules() {
        return [
            'category.title' => 'required',
            'tag.locale' => 'required|exists:locales,slug',
        ];
    }
}
