<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reading\IndexRequest;
use App\Http\Requests\Reading\ShowRequest;

class ReadingController extends ApiController
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
            $this->repository->find($request),
        );
    }
}
