<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;
use App\Http\Requests\Post\IndexRequest;
use App\Http\Requests\Post\ShowRequest;

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

    public function show(ShowRequest $request) {
        return $this->respondWithItem(
            $request,
            $this->repository->find($request),
        );
    }
}
