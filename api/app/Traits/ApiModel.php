<?php

namespace App\Traits;

use App\Fields\ComputedField;
use App\Fields\FilterableField;
use App\Fields\Field;
use App\Http\Resources\ApiResource;
use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait ApiModel
{
    protected array $collections = [];
    protected array $fields;
    protected array $items = [];

    private static array $fieldsMemo;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);

        if (!isset(self::$fieldsMemo)) {
            self::$fieldsMemo = [];

            $modelShortName = (new \ReflectionClass(static::class))->getShortName();
            $filesInNamespace = array_map(
                fn ($f) => pathinfo($f, PATHINFO_FILENAME),
                glob(app_path("Fields/$modelShortName/*.php"))
            );

            foreach ($filesInNamespace as $field) {
                self::$fieldsMemo[Str::snake($field)] = "App\\Fields\\$modelShortName\\$field";
            }
        }

        $this->fields = self::$fieldsMemo;
    }

    public function __call($method, $parameters) {
        $matches = [];
        if (preg_match('/where(Not)(.+)/', $method, $matches)) {
            return parent::__call('where', [Str::camel($matches[2]), '!=', $parameters[0]]);
        }

        return parent::__call($method, $parameters);
    }

    public function getCollections(): array {
        return $this->collections;
    }

    public function getField(string $slug, $data): ?Field {
        $filter = data_get($this->fields, $slug);

        if (!$filter) {
            return null;
        }

        if (!is_a($filter, Field::class, true)) {
            return abort(500, 'Fields must extend Field');
        }

        return new $filter($data);
    }

    public function getComputedFields(): array {
        return array_filter($this->fields, fn($f) => in_array(ComputedField::class, class_implements($f)));
    }

    public function getFields(): array {
        return $this->fields;
    }

    public function getFilterableFields(): array {
        return array_filter($this->fields, fn($f) => in_array(FilterableField::class, class_implements($f)));
    }

    /**
     * @param  array|string  $keys
     * @return array
     */
    public function getFieldsExcept($keys): array {
        return Arr::except($this->fields, $keys);
    }

    public function getItems(): array {
        return $this->items;
    }

    public function getResourceInstance($includedFields = [], $excludedFields = [], $pivot = null) {
        return new ApiResource($this, $includedFields, $excludedFields, $pivot);
    }

    public function getRules($action = '', array $input = []) {
        switch ($action) {
            default:
                return [];
        }
    }

    public function getValidationMessages(): array {
        return [];
    }
}
