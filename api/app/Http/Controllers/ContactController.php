<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\ApiRequest;
use App\Http\Requests\Contact\IndexRequest;
use App\Http\Requests\Contact\ShowRequest;
use App\Http\Requests\Contact\StoreRequest;

class ContactController extends ApiController
{
    public function index(IndexRequest $request) {
        return $this->respondWithCollection(
            $request,
            $this->repository->get($request),
        );
    }

    public function show(ShowRequest $request) {
        return $this->respondWithItem(
            $request,
            $this->repository->find($request, $request->getId()),
        );
    }

    public function store(StoreRequest $request) {
        return parent::validateAndStore($request);
    }
}
