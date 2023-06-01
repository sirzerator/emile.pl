<?php

namespace App\Http\Requests\Contact;

use App\Http\Requests\ApiRequest;

class StoreRequest extends ApiRequest
{
    public function rules() {
        return [
            'name' => 'required',
            'message' => 'required',
            'email' => 'email|required',
            'locale' => 'required|in:fr,en'
        ];
    }
}
