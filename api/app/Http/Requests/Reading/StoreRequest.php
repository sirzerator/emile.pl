<?php

namespace App\Http\Requests\Reading;

use App\Http\Requests\ApiRequest;

class StoreRequest extends ApiRequest
{
    public function rules() {
        return [
            'reading.title' => 'required',
            'reading.author' => 'required',
        ];
    }
}
