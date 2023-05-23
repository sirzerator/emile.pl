<?php

namespace App\Transformers;

use App\Fields\ComputedField;
use Illuminate\Support\Str;

class Transformer
{
    protected static $context = [];

    public function __construct(
        protected array $includedFields,
        protected array $excludedFields,
        protected ?array $pivot = null
    ) {
    }

    public function transform($model, $options = []) {
        $reflect = new \ReflectionClass($model);
        static::$context[$reflect->getShortName()] = $model->id;

        $output = $model->toArray();

        $this->addItems($output, $model);
        $this->addCollections($output, $model);
        $this->addComputedFields($output, $model);

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

        unset($output['pivot']);
        unset($output['laravel_through_key']);

        unset(static::$context[$reflect->getShortName()]);

        return $this->authorize($model, $output);
    }

    public function addComputedFields(&$output, &$model) {
        foreach ($model->getComputedFields() as $key => $field) {
            $output[$key] = $field::compute($model);
        }
    }

    public function addCollection($relation, &$output, &$model) {
        $camelRelation = Str::camel($relation);
        $reflect = new \ReflectionClass($model->{$camelRelation}()->getRelated());
        $shortName = $reflect->getShortName();
        $longName = $reflect->getName();
        $parentClassName = get_class($model);

        $target = $model->{$camelRelation};

        $transformer = $longName::getTransformerInstance([
            'includedFields' => data_get($this->includedFields, $relation, []),
            'excludedFields' => data_get($this->excludedFields, "!$relation", []),
            'pivot' => $model->pivot,
        ]);

        $output[$relation] = $target->map(function ($p) use ($transformer) {
            return $transformer->transform($p);
        });
    }

    protected function addCollections(&$output, &$model) {
        foreach ($model->getCollections() as $relation) {
            if ($this->shouldIncludeRelation($relation, $model)) {
                $this->addCollection($relation, $output, $model);
                continue;
            }

            if (isset($output[$relation])) {
                unset($output[$relation]);
            }
        }
    }

    protected function addItems(&$output, &$model) {
        foreach ($model->getItems() as $relation) {
            if ($this->shouldIncludeRelation($relation, $model)) {
                $this->addItem($relation, $output, $model);
                continue;
            }

            unset($output[$relation]);
        }
    }

    protected function addItem($relation, &$output, &$model) {
        $camelRelation = Str::camel($relation);
        if (!$model->{$camelRelation}) {
            $output[$relation] = null;
            return;
        }

        $transformer = $model->{$camelRelation}()->getRelated()::getTransformerInstance([
            'includedFields' => data_get($this->includedFields, $relation, []),
            'excludedFields' => data_get($this->excludedFields, "!$relation", []),
            'pivot' => $model->pivot,
        ]);
        $output[$relation] = $transformer->transform($model->{$camelRelation});
    }

    protected function authorize($model, $output) {
        return $output;
    }

    protected function shouldIncludeRelation($relation, &$model): bool {
        if (isset($this->includedFields['*']['*']) && !isset($this->excludedFields['*']['*'])) {
            return true;
        }

        return in_array($relation, array_keys($this->includedFields), true)
            && !in_array($relation, array_keys($this->excludedFields), true);
    }
}
