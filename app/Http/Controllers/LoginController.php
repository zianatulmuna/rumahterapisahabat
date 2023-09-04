<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('landing-page.login', [
            'title' => 'Login',
            'active' => 'login'
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required|min:3'
        ]);

        if (Auth::guard('admin')->attempt($credentials) || Auth::guard('terapis')->attempt($credentials) || Auth::guard('kepala_terapis')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('beranda');
        }
        
        

        return back()->with('loginError', 'Login Failed!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
