<?php

namespace App\Http\Requests\Tag;

use App\Http\Requests\BaseRequest;

class CreateRequest extends BaseRequest
{
    public function rules() {
        return [
            'tag.title' => 'required',
            'tag.slug' => 'required',
            'tag.locale' => 'required|exists:locales,slug',
        ];
    }
}
