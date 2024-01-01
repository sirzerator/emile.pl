<?php

namespace App\Repositories;

class Repository
{
    public function create($request, array $input) {
        $model = $request->getModel();

        $model->fill($input);

        if (!$model->save()) {
            throw new \Exception('Could not save');
        }

        return $model;
    }

    public function get($request) {
        $query = $request->getModel();

        // TODO
        // Filters
        $filterableFields = $request->getModel()->getFilterableFields();

        $queryParams = $request->query();
        foreach ($filterableFields as $fieldClass) {
            $filter = new $fieldClass($queryParams);
            $query = $filter->filter($query);
        }
        // Sorts
        $orders = $request->getOrders();
        foreach ($orders as $order) {
            $query = $order($query);
        }
        // Withs

        $total = $query->count();
        $items = $query->get();

        return new RepositoryCollection($items, $total);
    }

    public function find($request) {
        $query = $request->getModel();

        // TODO
        // Filters
        $filterableFields = $request->getModel()->getFilterableFields();

        $queryParams = $request->query();
        foreach ($filterableFields as $fieldClass) {
            $filter = new $fieldClass($queryParams);
            $query = $filter->filter($query);
        }
        // Sorts
        // Withs

        return $query->findOrFail($request->getId());
    }
}
