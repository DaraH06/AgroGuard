<?php

use App\Http\Controllers\autentikasi;
use App\Http\Controllers\crud_penyakit;
use App\Http\Controllers\dashboard;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('login', [autentikasi::class, 'login'])->name('login');
Route::get('/forgot-password', function () {
    return view('auth.forgot-password'); 
})->name('password.request');

Route::post('/forgot-password', function () {
    // Sementara kosongkan dulu atau beri feedback
    return "Link reset password telah dikirim ke email Anda! (Logika backend menyusul)";
})->name('password.email');

Route::prefix('api_admin')->name('api_admin.')->group(function() {
    Route::post('dashboard', [dashboard::class, 'index']);
    Route::get('map', [dashboard::class, 'mapVisualisasi']);
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard.dashboard');
    })->name('dashboard');

    Route::get('/manajemen-penyakit', function () {
        return view('admin.manajemenPenyakit.ManajemenPenyakit');
    })->name('manajemen-penyakit');

    Route::get('peta-sebaran', function(){
        return view('admin.peta.sebaran');
    })->name('peta-sebaran');

    Route::get('/penyakit/{id}', [crud_penyakit::class, 'show'])->name('penyakit.show');
    Route::post('/penyakit/store', [crud_penyakit::class, 'store'])->name('penyakit.store');
    Route::put('/penyakit/update', [crud_penyakit::class, 'update'])->name('penyakit.update');
    Route::delete('/penyakit/delete', [crud_penyakit::class, 'destroy'])->name('penyakit.delete');
});
