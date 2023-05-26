<?php

namespace App\Http\Controllers;

use App\Repositories\Repository;
use App\Http\Requests\Option\IndexRequest;
use App\Http\Requests\Option\ShowRequest;
use App\Http\Requests\Option\ShowGroupRequest;
use Validator;

class OptionController extends ApiController
{
    public function __construct(
        protected readonly Repository $repository,
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

    public function showGroup($group, IndexRequest $request) {
        $request->merge([ 'group' => $group ]);

        $validator = Validator::make($request->all(), [
            'group' => 'required',
            'locale' => 'required|in:fr,en',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 400,
            ], 400);
        }

        $data = $this->repository->get($request);

        return response()->json($data->items->keyBy('slug')->map(fn($t) => $t->value));
    }
}
