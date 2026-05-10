<?php

namespace App\Http\Controllers;

use App\Models\penyakit;
use Illuminate\Http\Request;

class crud_penyakit extends Controller
{
    function index(Request $req){
        $data = penyakit::project(['_id'=>0, 'created_at'=>0])->get();
        
        return $req->wantsJson() ? response()->json($data)
                : view('admin.manajemenPenyakit.ManajemenPenyakit', ['daftar_penyakit'=>$data]);
    }

    function store(Request $req, send_toFlask $flask)
    {
        $req->validate([
            'nama_penyakit' => 'required|string',
            'nama_ilmiah' => 'nullable|string',
            'dataset_zip' => 'nullable|file|mimes:zip|max:102400',
        ]);

        // Simpan data penyakit ke MongoDB
        $hasil = penyakit::create([
            'thumbnail' => 'contoh.jpg',
            'nama_penyakit' => $req->nama_penyakit,
            'nama_ilmiah' => $req->nama_ilmiah ?? '',
            'deskripsi' => $req->input('deskripsi', []),
            'penanganan' => $req->input('rekomendasi_penanganan', []),
            'penanggulangan' => $req->input('pencegahan', []),
            'jumlah dataset' => 0
        ]);

        $datasetResult = null;

        // Proses ZIP jika diupload
        if ($req->hasFile('dataset_zip')) {
            $zipFile = $req->file('dataset_zip');
            $extractPath = storage_path('app/datasets/' . uniqid('ds_'));

            $zip = new \ZipArchive;
            if ($zip->open($zipFile->getRealPath()) === true) {
                $zip->extractTo($extractPath);
                $zip->close();

                // Kirim ke Flask untuk ekstraksi fitur
                $datasetResult = $flask->prosesDataset($extractPath, $req->nama_penyakit);

                // Update jumlah dataset
                if ($datasetResult && ($datasetResult['success'] ?? false)) {
                    $hasil->update(['jumlah dataset' => $datasetResult['jumlah'] ?? 0]);
                }

                // Hapus folder temporary
                \Illuminate\Support\Facades\File::deleteDirectory($extractPath);
            }
        }

        if ($req->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Penyakit berhasil ditambahkan',
                'data' => $hasil,
                'dataset' => $datasetResult
            ]);
        }

        return redirect()->back()->with('success', 'Penyakit berhasil ditambahkan');
    }

    function show($id){
        $data = penyakit::findOrFail($id);
        return view('admin.penyakit.show', compact('data'));
    }

    function update(Request $req){
        $penyakit = penyakit::find($req->id);
        if($penyakit){
            $penyakit->update([
                'nama' => $req->nama_penyakit,
                'inang' => $req->inang
            ]);
            return redirect()->back()->with('success', 'berhasil diperbarui');
            }
        return redirect()->back()->with('success', 'data tidak ditemukan'); 
    }

    function destroy(Request $req){
        penyakit::where('_id', $req->id)->delete();
        return response()->json([
            'message'=>'oke',
        ]);
    }
}