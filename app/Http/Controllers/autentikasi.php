<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class autentikasi extends Controller
{
    function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            session(['email'=>$request->email]);
            return redirect()->intended('admin/dashboard');
        }
        return back()->withErrors(['email' => 'Email atau password salah!']);
    }
}
