<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (!auth()->user()->isSuperAdmin()) {
            return redirect('/dashboard')->with('error', 'Accès refusé. Réservé au Super Admin.');
        }

        return $next($request);
    }
}