<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::guard('admin')->user() || Auth::guard('terapis')->user()->id_terapis == 'KTR001') {
            return $next($request);

        }

        // if(in_array($request->user()->role, $roles)) {
        //     return $next($request);

        // }

        return redirect('/login');
    }
}
