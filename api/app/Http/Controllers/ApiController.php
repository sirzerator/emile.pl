<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiRequest;
use App\Repositories\Repository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as IlluminateController;

abstract class ApiController extends IlluminateController
{
    protected function respondWithCollection($request, $collection) {
        if (!$request instanceof ApiRequest) {
            return abort(500, 'Invalid request class: must extend ApiRequest');
        }

        $pagination = $request->getPagination();

        return (new LengthAwarePaginator(
            $this->prepareCollection($request, $collection->items),
            $collection->total,
            $pagination->perPage,
            $pagination->page,
        ))->withPath($request->fullUrlWithoutQuery('page'));
    }

    protected function respondWithItem($request, $item, $status = 200) {
        $result = $this->prepareItem($request, $item);

        return response($result, $status);
    }

    protected function prepareCollection($request, $items) {
        return $items->map(function ($item) use ($request) {
            return $this->prepareItem($request, $item);
        });
    }

    protected function prepareItem($request, $item) {
        return $item->getResourceInstance(
            $request->getFields(),
            $request->getExcludedFields(),
            data_get($item, 'pivot', null),
        );
    }
}
