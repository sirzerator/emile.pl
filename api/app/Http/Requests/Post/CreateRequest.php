<?php

namespace App\Http\Requests\Post;

use App\Http\Requests\BaseRequest;

class CreateRequest extends BaseRequest
{
    public function rules() {
        return [
            'post.title' => 'required',
            'post.slug' => 'required',
            'post.intro' => 'required',
            'post.content' => 'required',
        ];
    }
}
