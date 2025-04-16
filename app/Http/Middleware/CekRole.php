<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (auth()->check() && auth()->user()->role == $role) {
            return $next($request);
        }

        // Redirect atau abort kalau tidak sesuai role
        return redirect('/'); // atau abort(403);
    }
}
