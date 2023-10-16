<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isAdmin == 1) {
            // Als de gebruiker is ingelogd en isAdmin is 1 (admin), laat de request passeren
            return $next($request);
        }

        // Als de gebruiker geen admin is, kun je hier bepalen wat er moet gebeuren,
        // bijvoorbeeld doorverwijzen naar een andere pagina of een foutmelding weergeven.
        return redirect('/'); // Hier wordt de gebruiker teruggestuurd naar de startpagina
    }
}
