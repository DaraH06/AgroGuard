<?php

namespace App\Http\Controllers;

use App\Models\penyakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class crud_penyakit extends Controller
{
    function index(Request $req){
        $data = penyakit::project(['created_at'=>0])->get();
        
        return $req->wantsJson() ? response()->json([
            'success'=>true,
            'data'=> $data
            ]) : view('admin.manajemenPenyakit.ManajemenPenyakit', ['daftar_penyakit'=>$data]);
    }

    function store(Request $req, send_toFlask $flask)
    {
        $req->validate([
            'nama_penyakit' => 'required|string',
            'nama_ilmiah' => 'nullable|string',
            'thumbnail_file' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dataset_zip' => 'nullable|file|mimes:zip|max:102400',
        ]);

        $thumbnail = null;
        if ($req->hasFile('thumbnail_file')) {
            $photo = $req->file('thumbnail_file');
            $name = time() . '_' . $req->nama_penyakit . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images'), $name);
            $thumbnail = 'images/' . $name;
        }

        // Simpan data penyakit ke MongoDB
        $hasil = penyakit::create([
            'thumbnail' => $name,
            'nama_penyakit' => $req->nama_penyakit,
            'nama_ilmiah' => $req->nama_ilmiah ?? '',
            'deskripsi' => $req->input('deskripsi', []),
            'penanganan' => $req->input('rekomendasi_penanganan', []),
            'penanggulangan' => $req->input('pencegahan', []),
            'jumlah dataset' => 0,
            'lokasi csv' => '',
            'lokasi dataset' => ''
        ]);

        $datasetResult = null;
        $outputPath = storage_path('app/archieves/reports');

        // Proses ZIP jika diupload
        if ($req->hasFile('dataset_zip')) {
            $zipFile = $req->file('dataset_zip');
            $uniqId = uniqid('ds_');
            $extractPath = storage_path('app/archieves/images/' . $uniqId);

            $zip = new \ZipArchive;
            if ($zip->open($zipFile->getRealPath()) === true) {
                $zip->extractTo($extractPath);
                $zip->close();
                
                $zipFile->storeAs($hasil->nama_penyakit, $hasil->_id . '.zip');

                // Kirim ke Flask untuk ekstraksi fitur
                $datasetResult = $flask->prosesDataset($extractPath, $req->nama_penyakit, $outputPath);
                Log::info('Hasil ekstraksi dataset: ' . json_encode($datasetResult));

                $success = $datasetResult['success'] === true;

                // Update jumlah dataset
                if ($datasetResult && $success) {
                    $hasil->update(['jumlah dataset' => $datasetResult['jumlah'], 'lokasi csv' => $datasetResult['nama'], 'lokasi dataset' => $uniqId]);
                }else{
                    File::deleteDirectory($extractPath);
                    File::delete($thumbnail);
                    $hasil->delete();
                }
            }
        }

        $refresh = $flask->refreshModel();

        if ($success) {
            if($refresh['success']){
                return response()->json([
                    'success' => $success,
                    'message' => $datasetResult ? $datasetResult['message'] : 'Ada kesalahan saat memproses dataset',
                    'data' => $datasetResult['jumlah'],
                    'lokasi dataset csv' => $datasetResult['nama']
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Penyakit berhasil ditambahkan, tapi gagal refresh model: ' . $refresh['message']
                ], 500);
            }
        }else{
                return response()->json([
                    'success' => false,
                    'message' => $datasetResult ? $datasetResult['message'] : 'Ada kesalahan saat memproses dataset'
                ], 500);
        }
    }

    function update(Request $req){
        $req->validate([
            'nama_penyakit' => 'required|string',
            'nama_ilmiah'   => 'nullable|string',
            'thumbnail_file'=> 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $penyakit = penyakit::find($req->id);
        if (!$penyakit) {
            return response()->json([
                'success' => false,
                'message' => 'Data penyakit tidak ditemukan'
            ], 404);
        }

        $updateData = [
            'nama_penyakit'  => $req->nama_penyakit,
            'nama_ilmiah'    => $req->nama_ilmiah ?? '',
            'deskripsi'      => $req->input('deskripsi', []),
            'penanganan'     => $req->input('rekomendasi_penanganan', []),
            'penanggulangan' => $req->input('pencegahan', []),
        ];

        // Handle thumbnail update (optional)
        if ($req->hasFile('thumbnail_file')) {
            $photo = $req->file('thumbnail_file');
            $name  = time() . '_' . $req->nama_penyakit . '.' . $photo->getClientOriginalExtension();

            // Hapus thumbnail lama
            $oldThumbnail = $penyakit->thumbnail;
            if ($oldThumbnail && File::exists(public_path('images/' . $oldThumbnail))) {
                File::delete(public_path('images/' . $oldThumbnail));
            }

            $photo->move(public_path('images'), $name);
            $updateData['thumbnail'] = $name;
        }

        $penyakit->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Penyakit berhasil diperbarui'
        ]);
    }

    function destroy(Request $req, send_toFlask $flask){
        Log::info('Menerima permintaan delete untuk penyakit dengan ID: ' . $req->id);
        $query = penyakit::where('_id', $req->id)->first();
        if (!$query) {
            return response()->json([
                'success' => false,
                'message' => 'Penyakit tidak ditemukan'
            ], 404);
        }
        $path = $query->thumbnail;
        $path_dataset = $query->{'lokasi csv'};
        $path_gambar = $query->{'lokasi dataset'};
        if ($query->delete()) {
            ($path && File::exists(public_path('images/'.$path))) ?
                File::delete(public_path('images/'.$path)):
                Log::warning(("Thumbnail " . $path . " tidak ditemukan"));

            ($path_dataset && File::exists(storage_path('app/archieves/reports/'.$path_dataset))) ?
                File::delete(storage_path('app/archieves/reports/'.$path_dataset)) :
                Log::warning(("Dataset CSV " . $path_dataset . " tidak ditemukan"));

            ($path_gambar && File::exists(storage_path('app/archieves/images/'.$path_gambar))) ?
                File::deleteDirectory(storage_path('app/archieves/images/'.$path_gambar)) :
                Log::warning(("Dataset gambar " . $path_gambar . " tidak ditemukan"));
            
            $refresh = $flask->refreshModel();
            if($refresh['success']){
                return response()->json([
                    'success' => true,
                    'message' => 'Penyakit berhasil dihapus'
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Penyakit berhasil dihapus, tapi gagal refresh model: ' . $refresh['message']
                ], 500);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus penyakit'
            ], 500);
        }
    }
}