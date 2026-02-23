<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = auth()->user();

        if (! $user || ! $user->hasRole($role)) {
            abort(403, 'Bạn không có quyền truy cập.');
        }

        return $next($request);
    }
}