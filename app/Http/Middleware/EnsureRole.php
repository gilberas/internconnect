<?php

namespace App\Http\Middleware;

use Closure;

class EnsureRole
{
    public function handle($request, Closure $next, string $role)
    {
        if (! auth()->check() || auth()->user()->account_type !== $role) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
