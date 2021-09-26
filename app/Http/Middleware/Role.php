<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Role Middleware.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $names)
    {
        $nameArray = explode('|', $names);

        if (auth()->check() == false) {
            return $request->expectsJson()
            ? response()->json(['message' => 'Forbidden.'], 403)
            : redirect()->guest('login');
        }

        // Cek apakah grup user ada di dalam array $nameArray?
        if (auth()->user()->hasRoles($nameArray) == false) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden.'], 403);
            }

            flash(__('auth.unauthorized_access', ['url' => $request->path()]), 'danger');

            return redirect()->route('home');
        }

        return $next($request);
    }
}
