<?php

namespace App\Repositories;

class Repository
{
    public function get($request) {
        $pagination = $request->getPagination();

        $query = $request->getModel();

        // TODO
        // Filters
        $availableFilters = $request->getModel()->getFiltersExcept('pagination');
        foreach ($availableFilters as $filterClass) {
            if (!in_array($filterClass, $this->model->allowedFilters)) {
                continue;
            }

            $filter = new $filterClass($request->query());
            $query = $filter->apply($query);
        }
        // Sorts
        // Withs

        $query = $query
            ->take($pagination->perPage)
            ->skip($pagination->perPage * ($pagination->page - 1));

        $total = $query->count();
        $items = $query->get();

        return new RepositoryCollection($items, $total);
    }

    public function find($request) {
        $query = $request->getModel();

        return $query
            ->findOrFail($request->route('id'));
    }
}
