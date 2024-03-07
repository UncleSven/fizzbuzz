<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = [] === $guards ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard(name: $guard)->check()) {
                return redirect(to: RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
