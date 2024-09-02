<?php

namespace App\Http\Requests\Genre;

use App\Http\Requests\ApiRequest;

class StoreRequest extends ApiRequest
{
    public function rules() {
        return [
            'genre.title' => 'required',
            'genre.locale' => 'required|exists:locales,slug',
        ];
    }
}
