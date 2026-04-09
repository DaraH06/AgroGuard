<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('admin/dashboard');
    }

    return back()->withErrors(['email' => 'Email atau password salah!']);
})->name('login');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password'); 
})->name('password.request');

Route::post('/forgot-password', function () {
    // Sementara kosongkan dulu atau beri feedback
    return "Link reset password telah dikirim ke email Anda! (Logika backend menyusul)";
})->name('password.email');

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard.dashboard');
    })->name('dashboard');

    Route::get('/manajemen-penyakit', function () {
        return view('admin.manajemenPenyakit.ManajemenPenyakit');
    })->name('manajemen-penyakit');
});
