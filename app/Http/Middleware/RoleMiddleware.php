<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->session()->get('user');

        if (!$user) {
            return redirect()->route('login');
        }

        if (!empty($roles) && !in_array($user['role'], $roles)) {
            return abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
