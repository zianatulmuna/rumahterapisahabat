<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // return $request->expectsJson() ? null : route('beranda');
        if ($request->expectsJson()) {
            return null;
        }
        
        if(auth()->check()) {
            session()->flash('errorAuth', 'Halaman yang anda tuju tidak tersedia. Silahkan Login dengan akun yang sesuai!');
            return route('beranda');
        } else {
            session()->flash('errorAuth', 'Silahkan Login terlebih dahulu.');
            return route('login');
        }
    }
}
