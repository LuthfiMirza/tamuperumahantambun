<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }
        
        // Jika request URL mengandung 'satpam', arahkan ke login satpam
        if (str_contains($request->path(), 'satpam')) {
            return route('satpam.login');
        }
        
        return route('login');
    }
}
