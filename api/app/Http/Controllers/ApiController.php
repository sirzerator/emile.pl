<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as IlluminateController;

abstract class ApiController extends IlluminateController
{
    public function __construct() {
        $this->repository = new $this->repositoryClass;
    }

    protected function respondWithCollection($request, $collection) {
        if (!$request instanceof ApiRequest) {
            return abort(500, 'Invalid request class: must extend ApiRequest');
        }

        $pagination = $request->getPagination();

        return (new LengthAwarePaginator(
            $this->transformCollection($request, $collection->items),
            $collection->total,
            $pagination->perPage,
            $pagination->page,
        ))->withPath($request->fullUrlWithoutQuery('page'));
    }

    protected function respondWithItem($request, $item, $status = 200) {
        $result = $this->transformItem($request, $item);

        return response($result, $status);
    }

    protected function transformCollection($request, $items) {
        return $items->map(function ($item) use ($request) {
            return $this->transformItem($request, $item);
        });
    }

    protected function transformItem($request, $item) {
        $transformer = $item::getTransformerInstance();

        return $transformer->transform($item, []);
    }
}
