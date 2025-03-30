<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as PreventRequestsMaintenance;
use Closure;

class PreventRequestsDuringMaintenance extends PreventRequestsMaintenance
{
    public function handle($request, Closure $next)
    {
        if (app()->isDownForMaintenance()) {
            abort(503);
        }

        return $next($request);
    }
}
