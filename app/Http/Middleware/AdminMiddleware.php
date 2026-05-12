<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Vérifie si l'utilisateur est admin d'au moins une équipe
        $isAdmin = auth()->user()->teams()
                         ->wherePivot('role', 'admin')
                         ->exists();

        if (!$isAdmin) {
            return redirect('/dashboard')->with('error', 'Accès refusé. Vous devez être administrateur.');
        }

        return $next($request);
    }
}