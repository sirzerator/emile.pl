<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;
use App\Http\Requests\Post\IndexRequest;
use App\Http\Requests\Post\RetrieveRequest;

class PostController extends ApiController
{
    public function __construct(
        protected readonly PostRepository $repository,
    ) {
    }

    public function index(IndexRequest $request) {
        return $this->respondWithCollection(
            $request,
            $this->repository->get($request),
        );
    }

    public function retrieve(RetrieveRequest $request) {
        return $this->respondWithItem(
            $request,
            $this->repository->find($request),
        );
    }
}
