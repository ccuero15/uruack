<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();

        // Administrador (ID 1) tiene acceso total
        if ($user->rol_id == 1) {
            return $next($request);
        }

        // Recursos Humanos (ID 2) solo lectura (GET)
        if ($user->rol_id == 2) {
            if ($request->isMethod('get')) {
                return $next($request);
            }

            return abort(403, 'No tienes permisos para realizar esta acción.');
        }

        // Cualquier otro rol o sin rol, acceso denegado
        return abort(403, 'No tienes permisos para acceder a este recurso.');
    }
}
