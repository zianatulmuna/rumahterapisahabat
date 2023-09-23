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
        // $userKepala = $userTerapis->id_terapis === 'KTR001';
        // $userKepala = Auth::guard('kepala_terapis')->user();

        View::share('userAdmin', $userAdmin);
        View::share('userTerapis', $userTerapis);
        // View::share('userKepala', $userTerapis->id_terapis === 'KTR001');

        return $next($request);
    }
}
