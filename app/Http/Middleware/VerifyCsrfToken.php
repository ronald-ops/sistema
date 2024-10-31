<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Los URI que deberían ser excluidos de la verificación CSRF.
     *
     * @var array
     */
    protected $except = [
        // Puedes agregar aquí las rutas que deseas excluir de la verificación CSRF
    ];
}
