<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class send_toFlask extends Controller
{
    function Ekstraksigambar(string $name = "image.png"){
        $path = storage_path("app/uploads/$name");

        $response = Http::post('http://localhost:5000/ekstrak', [
            'path_foto'=> $name
        ]);

        return response()->json(['data' => $response->json()]);
    }
}
