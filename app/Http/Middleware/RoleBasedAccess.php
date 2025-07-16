<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleBasedAccess
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = $request->user();

        if ($user && $user->nama_role === $role) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}