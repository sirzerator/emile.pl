<?php

namespace App\Models;

use App\Http\Filters\Filter;
use App\Transformers\BaseTransformer;
use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Model extends EloquentModel
{
    protected array $filters;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);

        $shortName = (new \ReflectionClass(static::class))->getShortName();
        $filters = ClassFinder::getClassesInNamespace("App\Http\Filters\\$shortName");

        $this->filters = [];

        foreach ($filters as $filter) {
            $this->filters[Str::snake(((new \ReflectionClass($filter))->getShortName()))] = $filter;
        }
    }

    public static function getTransformerInstance() {
        return new BaseTransformer();
    }

    public function __call($method, $parameters) {
        $matches = [];
        if (preg_match('/where(Not)(.+)/', $method, $matches)) {
            return parent::__call('where', [Str::camel($matches[2]), '!=', $parameters[0]]);
        }

        return parent::__call($method, $parameters);
    }

    public function getFilter(string $slug, $data): ?Filter {
        $filter = data_get($this->filters, $slug);

        if (!$filter) {
            return null;
        }

        if (!is_a($filter, Filter::class, true)) {
            return abort(500, 'Filters must extend Filter');
        }

        return new $filter($data);
    }

    public function getFilters(): Collection {
        return $this->filters;
    }

    /**
     * @param  array|string  $keys
     * @return array
     */
    public function getFiltersExcept($keys): array {
        return Arr::except($this->filters, $keys);
    }
}
