<?php

namespace App\Http\Controllers;

use App\Http\Requests\Genre\IndexRequest;
use App\Http\Requests\Genre\ShowRequest;

class GenreController extends ApiController
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
