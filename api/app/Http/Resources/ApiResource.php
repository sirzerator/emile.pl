<?php

namespace App\Http\Resources;

use App\Fields\ComputedField;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ApiResource extends JsonResource
{
    protected static $context = [];

    public function __construct(
        public $resource,
        protected array $includedFields = [],
        protected array $excludedFields = [],
        protected $pivot = null,
    ) {
    }

    public function toArray($request) {
        $reflect = new \ReflectionClass($this->resource);
        $key = "{$reflect->getShortName()}:{$this->id}";

        static::$context[] = $key;

        $output = parent::toArray($request);

        $this->addComputedFields($output, $this->resource);

        if (!in_array('*', array_keys($this->includedFields), true)) {
            $output = array_intersect_key(
                $output,
                array_merge(array_flip(array_keys($this->includedFields)), ['id' => true]),
            );
        }

        if (in_array('*', array_keys($this->excludedFields), true)) {
            $output = array_intersect_key($output, ['id' => true]);
        }

        $output = array_diff_key($output, array_merge(array_flip(array_keys($this->excludedFields))));

        $this->addItems($output, $this->resource);
        $this->addCollections($output, $this->resource);

        unset($output['pivot']);
        unset($output['laravel_through_key']);

        return $this->authorize($this->resource, $output);
    }

    public function addComputedFields(&$output, &$resource) {
        foreach ($resource->getComputedFields() as $key => $field) {
            $output[$key] = $field::compute($resource);
        }
    }

    public function addCollection($relationName, &$output, &$resource) {
        $camelRelationName = Str::camel($relationName);
        $targetRelation = $resource->{$camelRelationName};

        $output[$relationName] = $targetRelation->map(function ($item) use ($relationName) {
            return $item->getResourceInstance(
                $this->getIncludedFieldsFor($relationName),
                $this->getExcludedFieldsFor($relationName),
                $this->resource->pivot,
            );
        });
    }

    protected function addCollections(&$output, &$resource) {
        foreach ($resource->getCollections() as $relation) {
            if ($this->shouldIncludeRelation($relation, $resource)) {
                $this->addCollection($relation, $output, $resource);
                continue;
            }

            if (isset($output[$relation])) {
                unset($output[$relation]);
            }
        }
    }

    protected function addItems(&$output, &$resource) {
        foreach ($resource->getItems() as $relation) {
            if ($this->shouldIncludeRelation($relation, $resource)) {
                $this->addItem($relation, $output, $resource);
                continue;
            }

            unset($output[$relation]);
        }
    }

    protected function addItem($relation, &$output, &$resource) {
        $camelRelation = Str::camel($relation);
        if (!$resource->{$camelRelation}) {
            $output[$relation] = null;
            return;
        }

        $output[$relation] = $resource->{$camelRelation}->getResourceInstance(
            $this->getIncludedFieldsFor($camelRelation),
            $this->getExcludedFieldsFor($camelRelation),
            $resource->pivot,
        );
    }

    protected function authorize($resource, $output) {
        return $output;
    }

    protected function shouldIncludeRelation($relation, &$resource): bool {
        if (isset($this->includedFields['*']['*']) && !isset($this->excludedFields['*']['*'])) {
            return true;
        }


        if (in_array($relation, array_keys($this->excludedFields), true)) {
            if ($this->excludedFields[$relation] === true || isset($this->excludedFields[$relation]['*'])) {
                return false;
            }

            return true;
        }

        return in_array($relation, array_keys($this->includedFields), true)
            || (in_array('*', array_keys($this->includedFields), true) && is_array($this->includedFields['*']));
    }

    protected function getExcludedFieldsFor($relationName) {
        $excludedFields = data_get($this->excludedFields, $relationName, []);

        if (isset($this->excludedFields['*']) && is_array($this->excludedFields['*'])) {
            $excludedFields = array_merge($excludedFields, $this->excludedFields['*']);
        }

        return $excludedFields;
    }

    protected function getIncludedFieldsFor($relationName) {
        $includedFields = data_get($this->includedFields, $relationName, []);

        if (isset($this->includedFields['*']) && is_array($this->includedFields['*'])) {
            $includedFields = array_merge($includedFields, $this->includedFields['*']);
        }

        return $includedFields;
    }
}
