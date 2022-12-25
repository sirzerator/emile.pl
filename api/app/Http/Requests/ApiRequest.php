<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class ApiRequest extends FormRequest
{
    protected $model;

    public function getModel() {
        if (!$this->model) {
            $modelName = data_get(explode('\\', static::class), 3);

            if (!$modelName) {
                return abort(500, 'Unable to determine model class name');
            }

            $this->model = new ("App\\Models\\$modelName");
        }

        return $this->model;
    }

    public function getPagination() {
        return $this->getModel()->getFilter('pagination', $this->query());
    }

    public function rules() {
        return [];
    }
}
