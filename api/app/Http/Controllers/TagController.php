<?php

namespace App\Http\Controllers;

use App\Repositories\TagRepository;
use App\Http\Requests\Tag\ApiRequest;
use App\Http\Requests\Tag\IndexRequest;
use App\Http\Requests\Tag\ShowRequest;

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

    public function show(ShowRequest $request) {
        return $this->respondWithItem(
            $request,
            $this->repository->find($request),
        );
    }
}
