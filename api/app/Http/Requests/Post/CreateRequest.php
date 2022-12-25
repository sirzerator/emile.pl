<?php

namespace App\Http\Requests\Post;

use App\Http\Requests\ApiRequest;

class CreateRequest extends ApiRequest
{
    public function rules() {
        return [
            'post.title' => 'required',
            'post.slug' => 'required',
            'post.intro' => 'required',
            'post.content' => 'required',
            'post.locale' => 'required|exists:locales,slug',
        ];
    }
}
