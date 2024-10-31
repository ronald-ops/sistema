<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Obtiene la ruta a la que el usuario debe ser redirigido si no está autenticado.
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login'); // Redirige a la ruta 'login' si no está autenticado
        }
    }
}
