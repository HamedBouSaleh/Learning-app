<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return response()->json([
                'error' => 'Unauthorized - Please login'
            ], 401);
        }

        $user = auth()->user();

        // Check if user has required role
        if (!in_array($user->role, $roles)) {
            return response()->json([
                'error' => 'Forbidden - You do not have permission to access this resource'
            ], 403);
        }

        return $next($request);
    }
}