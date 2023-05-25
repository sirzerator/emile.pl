<?php

namespace App\Http\Requests\Post;

use App\Http\Requests\ApiRequest;

class StoreRequest extends ApiRequest
{
    public function rules() {
        return [
            'post.title' => 'required',
            'post.intro' => 'required',
            'post.content' => 'required',
            'post.locale' => 'required|exists:locales,slug',
        ];
    }
}
