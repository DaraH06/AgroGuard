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

    function store(Request $req)
    {
        $hasil = penyakit::create([
            'nama_penyakit' => $req->nama_penyakit,
            'inang' => $req->inang
        ]);

        return response()->json([
            'message' => 'berhasil',
            'data' => $hasil
        ]);
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