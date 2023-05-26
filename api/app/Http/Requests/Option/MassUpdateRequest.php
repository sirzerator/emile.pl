<?php

namespace App\Http\Requests\Option;

use App\Http\Requests\ApiRequest;
use Illuminate\Support\Collection;

class MassUpdateRequest extends ApiRequest
{
    public function getOptionsData(): Collection {
        $options = collect();

        foreach ($this->input('options') as $locale => $data) {
            foreach ($data as $group => $tuples) {
                foreach ($tuples as $key => $value) {
                    $options->push([
                        'locale' => $locale,
                        'group' => $group,
                        'value' => $value ?: '',
                        'slug' => $key,
                    ]);
                }
            }
        }

        return $options;
    }
}
