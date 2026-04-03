<?php

use App\Http\Controllers\crud_penyakit;
use Illuminate\Support\Facades\Route;

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

    Route::get('/penyakit/{id}', [crud_penyakit::class, 'show'])->name('penyakit.show');
    Route::post('/penyakit/store', [crud_penyakit::class, 'store'])->name('penyakit.store');
    Route::put('/penyakit/update', [crud_penyakit::class, 'update'])->name('penyakit.update');
    Route::delete('/penyakit/delete', [crud_penyakit::class, 'destroy'])->name('penyakit.delete');
});
