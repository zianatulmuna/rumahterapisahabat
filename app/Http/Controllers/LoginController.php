<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages.landing-page.login', [
            'title' => 'Login',
            'active' => 'login'
        ]);
    }

    public function login(Request $request)
    {
        $message = [
            'required' => 'Kolom :attribute harus diisi.',
            'min' => 'Kolom :attribute harus diisi minimal :min karakter.'
        ];

        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required|min:3|max:30'
        ], $message);

        if (Auth::guard('admin')->attempt($credentials) || Auth::guard('terapis')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('beranda');
        }

        return back()->with('loginError', true);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
