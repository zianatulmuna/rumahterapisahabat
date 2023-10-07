<?php

namespace App\Http\Middleware;

use App\Models\Terapis;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthDataUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userAdmin = Auth::guard('admin')->user();

        $userTerapis = Auth::guard('terapis')->user();
        $userKepala = $userTerapis && $userTerapis->is_kepala ? $userTerapis : null;

        View::share('userAdmin', $userAdmin);
        View::share('userTerapis', $userTerapis);
        View::share('userKepala', $userKepala);

        return $next($request);
    }
}
