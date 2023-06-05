<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\ApiRequest;

class StoreRequest extends ApiRequest
{
    public function rules() {
        return [
            'category.title' => 'required',
            'category.locale' => 'required|exists:locales,slug',
        ];
    }
}
