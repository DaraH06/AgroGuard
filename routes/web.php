<?php

use App\Http\Controllers\crud_penyakit;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard.dashboard');
    })->name('dashboard');

    Route::get('/manajemen-penyakit', function () {
        return view('admin.manajemenPenyakit.ManajemenPenyakit');
    })->name('manajemen-penyakit');

    Route::post('/penyakit/store', [crud_penyakit::class, 'store'])->name('penyakit.store');
});
