<?php

namespace App\Http\Controllers;

use App\Repositories\TagRepository;
use App\Http\Requests\Tag\IndexRequest;
use App\Http\Requests\Tag\RetrieveRequest;

class TagController extends ApiController
{
    public function __construct(
        protected readonly TagRepository $repository,
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
