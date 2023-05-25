<?php

namespace App\Http\Requests\Tag;

use App\Http\Requests\ApiRequest;

class StoreRequest extends ApiRequest
{
    public function rules() {
        return [
            'tag.title' => 'required',
            'tag.locale' => 'required|exists:locales,slug',
        ];
    }
}
