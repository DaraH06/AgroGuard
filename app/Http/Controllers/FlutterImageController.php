<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FlutterImage;
use Illuminate\Http\Request;

class FlutterImageController extends Controller
{
       public function upload(Request $request, send_toFlask $FlaskService)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);

            $file = $request->file('image');
            $originalFilename = $file->getClientOriginalName();
            $mimeType = $file->getMimeType();
            $fileSize = $file->getSize();

            $path = $file->store('uploads', 'public');

            // Call Flask service and capture extraction result
            $flaskResult = $FlaskService->Ekstraksigambar($path);

            $upload = FlutterImage::create([
                'image_path' => $path,
                'filename' => basename($path),
                'original_filename' => $originalFilename,
                'file_size' => $fileSize,
                'mime_type' => $mimeType,
                'uploaded_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil diupload',
                'data' => [
                    'id' => $upload->id,
                    'image_path' => $upload->image_path,
                    'image_url' => $upload->image_url,
                    'original_filename' => $upload->original_filename,
                    'file_size' => $upload->file_size,
                    'uploaded_at' => $upload->uploaded_at,
                ],
                // Sertakan hasil ekstraksi dari Flask (jika ada)
                'extraction' => $flaskResult ?? null,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat upload',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        try {
            $uploads = FlutterImage::latest('uploaded_at')->paginate(12);

            return response()->json([
                'success' => true,
                'message' => 'Data upload berhasil diambil',
                'data' => $uploads->items(),
                'pagination' => [
                    'total' => $uploads->total(),
                    'per_page' => $uploads->perPage(),
                    'current_page' => $uploads->currentPage(),
                    'last_page' => $uploads->lastPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
