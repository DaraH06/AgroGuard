<?php
use App\Http\Controllers\send_toFlask;
use App\Http\Controllers\FlutterImageController;
use App\Http\Controllers\KondisiController;
use Illuminate\Support\Facades\Route;

Route::post('ekstrak', [send_toFlask::class, 'Ekstraksigambar'])->name('ekstrak');

// API untuk upload gambar dari Flutter
Route::post('upload', [FlutterImageController::class, 'upload']);
Route::get('uploads', [FlutterImageController::class, 'index']);

// API kondisi sekitar — data kasus penyakit untuk Flutter
Route::get('kondisi', [KondisiController::class, 'index']);