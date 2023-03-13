<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class WrapInTransaction
{
    public function handle($request, Closure $next, $guard = null) {
        DB::beginTransaction();

        $response = $next($request);

        $status = (int) $response->getStatusCode();
        if (in_array($status, [400, 500])) {
            return $response;
        }

        DB::commit();

        return $response;
    }
}
