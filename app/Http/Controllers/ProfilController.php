<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index () {
        $user = auth()->user();
        $tanggal_lahir = Carbon::parse($user->tanggal_lahir )->formatLocalized('%A, %d %B %Y');

        return view('user.profil', compact('user', 'tanggal_lahir'));
    }
    public function edit () {
        $user = auth()->user();

        return view('user.edit', compact('user'));
    }
}
