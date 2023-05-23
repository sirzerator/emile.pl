<?php

namespace App\Repositories;

class Repository
{
    public function get($request) {
        $query = $request->getModel();

        // TODO
        // Filters
        $parameters = $request->query();
        $filterableFields = $request->getModel()->getFilterableFields();

        $queryParams = $request->query();
        foreach ($filterableFields as $fieldClass) {
            $filter = new $fieldClass($queryParams);
            $query = $filter->filter($query);
        }
        // Sorts
        // Withs

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
