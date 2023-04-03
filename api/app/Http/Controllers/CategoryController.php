<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Http\Requests\Category\IndexRequest;
use App\Http\Requests\Category\RetrieveRequest;

class CategoryController extends ApiController
{
    public function __construct(
        protected readonly CategoryRepository $repository,
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