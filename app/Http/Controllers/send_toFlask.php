<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class send_toFlask extends Controller
{
    function Ekstraksigambar(string $name = "image.png"){
        // Build full path to where files are stored by FlutterImageController
        // FlutterImageController uses: $file->store('uploads', 'public') -> storage/app/public/uploads/...
        $path = storage_path("app/public/{$name}");

        // Fallback if file is stored in storage/app/uploads (older behavior)
        if (!file_exists($path)) {
            $alt = storage_path("app/{$name}");
            if (file_exists($alt)) {
                $path = $alt;
            } else {
                return ['status' => false, 'message' => 'File tidak ditemukan', 'path_tried' => $path];
            }
        }

        $response = Http::post('http://localhost:5000/ekstrak', [
            'path_foto'=> $path
        ]);

        // Return Flask JSON decoded as array so callers can include it in their response
        return $response->json();
    }
}
