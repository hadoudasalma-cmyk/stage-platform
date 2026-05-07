<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStudent
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isStudent()) {
            return $next($request);
        }

        abort(403, 'Accès réservé aux étudiants.');
    }
}
