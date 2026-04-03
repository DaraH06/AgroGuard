<?php

namespace App\Http\Controllers;

use App\Models\penyakit;
use Illuminate\Http\Request;

class crud_penyakit extends Controller
{
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
}
