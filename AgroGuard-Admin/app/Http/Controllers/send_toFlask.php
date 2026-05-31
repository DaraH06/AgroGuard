<?php

namespace App\Http\Controllers;

use App\Models\penyakit;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class send_toFlask extends Controller
{
    function Ekstraksigambar(string $name = "image.png"){
        $path = storage_path("app/public/{$name}");

        if (!file_exists($path)) {
            $alt = storage_path("app/{$name}");
            if (file_exists($alt)) {
                $path = $alt;
            } else {
                return ['success' => false, 'message' => 'File tidak ditemukan', 'path_tried' => $path];
            }
        }
        $response = null;
        try{
            $response = Http::timeout(120)->withHeaders([
                'X-API-KEY' => config('services.flask.key')])
                ->post(config('services.flask.uri').'ekstrak',[
                    'path_foto'=> $path
            ]);
        } catch (ConnectionException $e) {
            return ['success' => false, 'message' => 'Koneksi ke layanan gagal karena sedang pembaruan. Coba lagi nanti'];
        }

        $cleaned = $this->cleaningResponse(
            json_decode($response, true));
        
        if ($cleaned['success'] == false){
            Log::error($cleaned);
            return $cleaned;
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
                return $value != 0.00;
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
        ->select(['nama_penyakit', 'deskripsi', 'penanganan', 'penanggulangan'])
        ->first();

        // Log::info($solusi);
        if($solusi) unset($solusi->_id);

        return [
            'success'=>true,
            'nama_penyakit' => $nama,
            'hasil'=>$solusi ? $solusi->toArray() : null,
            'tingkat keyakinan' => $data['tingkat_keyakinan']];
    }

    /**
     * Kirim folder gambar ke Flask untuk ekstraksi fitur dan simpan ke MongoDB
     */
    function prosesDataset(string $folderPath, string $label, string $outputPath)
    {   
        try{
            $response = Http::timeout(300)
                ->withHeaders(['X-API-KEY' => config('services.flask.key')])
                ->post(config('services.flask.uri').'proses-dataset', [
                    'path_folder' => $folderPath,
                    'label' => $label,
                    'path_result'=> $outputPath
                ]);
            
            return json_decode($response, true);
        }catch(ConnectionException $e){
            return ['success' => false, 'message' => 'Tidak dapat menhubungi model. Hubungi developer atau administrator.'];
        }
    }

    /**
     * Minta Flask untuk refresh/train ulang model KNN
     */
    function refreshModel()
    {   
        try{
            $response = Http::timeout(60)
                ->withHeaders(['X-API-KEY' => config('services.flask.key')])
                ->post(config('services.flask.uri').'refresh_model');
                
                Log::info('Response refresh model: ' . $response);
                return json_decode($response, true);
        }catch(ConnectionException $e){
            return ['success' => false, 'message' => 'Tidak dapat menghubungi model untuk refresh. Hubungi developer atau administrator.'];
        }
    }
}
