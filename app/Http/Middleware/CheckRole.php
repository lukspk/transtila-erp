<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {

        if (!Auth::check()) {
            return redirect('login');
        }

        foreach ($roles as $role) {
            if ($request->user()->hasRole($role)) {

                return $next($request);
            }
        }

        // 4. Se o loop terminar e ele não tiver nenhum dos papéis, ele é barrado.
        abort(403, 'ACESSO NÃO AUTORIZADO.');
    }
}
