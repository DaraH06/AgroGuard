<?php
use App\Http\Controllers\send_toFlask;
use Illuminate\Support\Facades\Route;

Route::post('ekstrak', [send_toFlask::class, 'Ekstraksigambar']);