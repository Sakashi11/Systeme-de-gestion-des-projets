<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MustChangePasswordMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->must_change_password) {
            if (!$request->is('password/change') && !$request->is('logout')) {
                return redirect('/password/change')->with('warning', 'Vous devez changer votre mot de passe avant de continuer.');
            }
        }

        return $next($request);
    }
}