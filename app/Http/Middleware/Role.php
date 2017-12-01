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
            return redirect()->guest('login');
        }

        // Cek apakah grup user ada di dalam array $nameArray?
        if (auth()->user()->hasRoles($nameArray) == false) {
            flash()->error('Anda tidak dapat mengakses halaman '.$request->path().'.');
            return redirect()->route('home');
        }

        return $next($request);
    }
}
