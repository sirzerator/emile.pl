<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;
use Closure;

class ConvertEmptyStringsToNullInFormsOnly extends TransformsRequest
{
    protected static $skipCallbacks = [];

    public function handle($request, Closure $next) {
        $segments = $request->segments();

		$lastSegment = '';
		if (count($segments) > 1) {
			$lastSegment = $segments[count($segments) - 1];
		}
        if ($request->isJson() && $lastSegment !== 'relation') {
            return $next($request);
        }

        foreach (static::$skipCallbacks as $callback) {
            if ($callback($request)) {
                return $next($request);
            }
        }

        return parent::handle($request, $next);
    }

    protected function transform($key, $value) {
        return $value === '' ? null : $value;
    }

    public static function skipWhen(Closure $callback) {
        static::$skipCallbacks[] = $callback;
    }
}
