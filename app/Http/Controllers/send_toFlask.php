<?php

namespace App\Http\Controllers;

use App\Models\penyakit;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class send_toFlask extends Controller
{
    function Ekstraksigambar(string $name = "image.png"){
        $path = storage_path("app/public/{$name}");

        if (!file_exists($path)) {
            $alt = storage_path("app/{$name}");
            if (file_exists($alt)) {
                $path = $alt;
            } else {
                return ['status' => false, 'message' => 'File tidak ditemukan', 'path_tried' => $path];
            }
        }

        $response = Http::withHeaders([
            'X-API-KEY' => config('services.flask.key')])
            ->post(config('services.flask.uri').'ekstrak',[
                'path_foto'=> $path
        ]);

        $cleaned = $this->cleaningResponse(
            json_decode($response, true));
        
        if ($cleaned['success'] == false){
            Log::error($cleaned);
            return $cleaned->json();
        }

        return tap($this->getSolusi($cleaned['data']), function ($x){
            Log::debug($x);
        });
    }

    private function cleaningResponse($response){
        if ($response['success']){
            $hasil = $response['data']['hasil'];
            $keyakinan = $response['data']['tingkat_keyakinan'];
            $keyakinan_3 = [];

            foreach ($keyakinan as $item){
                foreach ($item as $key => $value){
                    $keyakinan_3[$key] = $value;
                }
            }
            $keyakinan_3 = array_filter($keyakinan_3, function($value){
                return $value !== "0,00%";
            });
            arsort($keyakinan_3);
            $top3 = array_slice($keyakinan_3, 0, 3, true);

            return ['success'=>true, 'data'=>[
                'hasil'=>$hasil,
                'tingkat_keyakinan'=>$top3
            ]];
        }else{
            return $response;
        }
    }

    private function getSolusi($data){
        $nama = trim($data['hasil']);
        $solusi = penyakit::where('nama_penyakit', $nama)
        ->project(['_id'=>0])
        ->select(['nama_penyakit', 'penanganan', 'penanggulangan'])
        ->first();

        // Log::info($solusi);
        if($solusi) unset($solusi->_id);

        return [
            'success'=>true,
            'hasil'=>$solusi ? $solusi->toArray() : null,
            'tingkat keyakinan' => $data['tingkat_keyakinan']];
    }
}
