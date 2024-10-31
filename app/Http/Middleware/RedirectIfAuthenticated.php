<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Maneja una solicitud entrante.
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect('auth.login'); // Cambia '/home' según tu ruta de inicio
        }

        return $next($request);
    }
}
