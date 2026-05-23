<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChefProjetMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (!auth()->user()->isChefProjet() && !auth()->user()->isSuperAdmin()) {
            return redirect('/dashboard')->with('error', 'Accès refusé. Réservé au Chef de Projet.');
        }

        return $next($request);
    }
}