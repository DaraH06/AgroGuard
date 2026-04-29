<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FlutterImage;
use Illuminate\Http\Request;

class FlutterImageController extends Controller
{
    /**
     * Upload gambar dari Flutter
     * Request: multipart/form-data dengan field 'image'
     */
    public function upload(Request $request)
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

    /**
     * Ambil semua data upload
     */
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
