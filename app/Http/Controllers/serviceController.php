<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class serviceController extends Controller{
    function updateLog($request, $flaskResult){
        if (isset($flaskResult['success']) && $flaskResult['success'] == true) {
            $hasil = $flaskResult['nama_penyakit'] ?? 'Unknown';

            if ($hasil !== 'Healthy' && $hasil !== 'Unknown') {
                // Extract confidence percentage
                $tingkat_keyakinan = 0.0;
                if (isset($flaskResult['tingkat keyakinan']) && is_array($flaskResult['tingkat keyakinan'])) {
                    foreach ($flaskResult['tingkat keyakinan'] as $key => $value) {
                        if ($key === $hasil) {
                            $tingkat_keyakinan = round($value, 2);
                            break;
                        }
                    }
                }

                \App\Models\log_klasifikasi::create([
                    'hasil_label' => $hasil,
                    'keyakinan_model' => $tingkat_keyakinan,
                    'lokasi' => [
                        'provinsi' => $request->input('provinsi', 'Tidak diketahui'),
                        'kabupaten' => $request->input('kabupaten', 'Tidak diketahui'),
                        'kecamatan' => $request->input('kecamatan', 'Tidak diketahui'),
                        'koordinat' => [
                            (float) $request->input('latitude', 0),
                            (float) $request->input('longitude', 0),
                        ],
                    ],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    function cleaningResponse($response){
        $dump = $response;
        $rate = $response['tingkat keyakinan'];
        $keyakinan = [];
        foreach ($rate as $item => $value){
            $keyakinan[$item] = round($value, 2) * 100 . '%';
        }
        $dump['tingkat keyakinan'] = $keyakinan;
        return $dump;
    }
}
