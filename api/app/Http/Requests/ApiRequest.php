<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ApiRequest extends FormRequest
{
    protected static $model;

    protected $fieldsMemo;
    protected $excludedFieldsMemo;

    // PHP's default query string parser replaces . by _
    // which would break our query language
    public static function parseQueryString($data) {
        $data = preg_replace_callback('/(?:^|(?<=&))[^=[]+/', function ($match) {
            return bin2hex(urldecode($match[0]));
        }, $data);

        parse_str($data, $values);

        return array_combine(array_map('hex2bin', array_keys($values)), $values);
    }

    public function getExcludedFields(): array {
        if ($this->excludedFieldsMemo !== null) {
            return $this->excludedFieldsMemo;
        }

        $excludedFields = $this->query('!fields');

        if (!$excludedFields) {
            return $this->excludedFieldsMemo = [];
        }

        return $this->excludedFieldsMemo = $this->parseFields(
            $this->splitFields($excludedFields)
        );
    }

    public function getFields(): array {
        if ($this->fieldsMemo !== null) {
            return $this->fieldsMemo;
        }

        $fields = $this->query('fields') ?: implode(',', $this->getModel()->getFillable());

        if (!$fields) {
            return $this->fieldsMemo = [];
        }

        return $this->fieldsMemo = $this->parseFields(
            $this->splitFields($fields)
        );
    }

    public function getId() {
        $route = $this->route();
        $routeName = $route->getName();

        [$resourceNamePlural, $_] = explode('.', "{$routeName}.");

        $resourceName = Str::singular($resourceNamePlural);

        return data_get($route->parameters(), $resourceName)
            ?: $this->query('id')
            ?: $this->input('id');
    }

    public function getModel() {
        if (self::$model !== null) {
            return self::$model;
        }

        $modelName = data_get(explode('\\', static::class), 3);

        if (!$modelName) {
            return abort(500, 'Unable to determine model class name');
        }

        return self::$model = new ("App\\Models\\$modelName");
    }

    public function getPagination() {
        return $this->getModel()->getField('pagination', $this->query());
    }

    public function rules() {
        return [];
    }

    private function splitFields($fields) {
        $parts = array_map('trim', explode(',', $fields));
        return array_map(function ($f) {
            return array_map('trim', explode('.', $f, 2));
        }, $parts);
    }

    private function parseFields($fields, &$acc = []) {
        return array_reduce($fields, function ($acc, $t) {
            switch (count($t)) {
                case 2:
                    if (!isset($acc[$t[0]])) {
                        $acc[$t[0]] = [];
                    }

                    if (strpos($t[1], '.') !== false) {
                        $st = $this->splitFields($t[1]);
                        $acc[$t[0]] = $this->parseFields($st, $acc[$t[0]]);
                    } else {
                        if (is_string($acc[$t[0]])) {
                            $str = $acc[$t[0]];
                            $acc[$t[0]] = [];
                            $acc[$t[0]][$str] = $str;
                        }
                        $acc[$t[0]][$t[1]] = true;
                    }
                    break;
                case 1:
                    $acc[$t[0]] = true;
                    break;
                default:
                    $acc[] = $t;
                    break;
            }
            return $acc;
        }, $acc);
    }

    public function input($key = null, $default = null)
    {
        return data_get(
            $this->getInputSource()->all() + self::parseQueryString(data_get($this->server->all(), 'QUERY_STRING')),
            $key,
            $default
        );
    }

    public function query($key = null, $default = null) {
        $queryParameters = self::parseQueryString(data_get($this->server->all(), 'QUERY_STRING'));

        if (!$key) {
            return $queryParameters;
        }

        return data_get($queryParameters, $key, $default);
    }
}
