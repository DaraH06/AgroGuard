<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class send_toFlask extends Controller
{
    function Ekstraksigambar(Request $req){
        $path = $req->validate(['path'=> 'required|string']);

        $response = Http::post('http://localhost:5000/ekstrak', [
            'path_foto'=> $path['path']
        ]);

        return response()->json($response->json());
    }
}
