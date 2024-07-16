<?php

namespace App\Http\Middleware\Api;

use App\Enums\CustomHeaders;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;

class CustomThrottle extends ThrottleRequests
{
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = '') {
        if ($request->hasHeader(CustomHeaders::GENERATE_MODE) && $request->header(CustomHeaders::GENERATE_MODE) == "true") {
            return $next($request);
        }
        parent::handle($request, $next, $maxAttempts, $decayMinutes, $prefix);
    }
}
