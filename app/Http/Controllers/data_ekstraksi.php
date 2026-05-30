<?php

namespace App\Http\Controllers;

use App\Models\DataEkstraksi;

class data_ekstraksi extends Controller
{
    function updateData($filename){
        $path = storage_path("app/archieves/reports/{$filename}");
    
        if (!file_exists($path)) {
            return ['success' => false, 'message' => "File tidak ditemukan {$path}"];
        }

        $file = fopen($path, 'r');
        $header = fgetcsv($file);

        $count = 0;
        while (($row = fgetcsv($file)) !== false) {
            $data = array_combine($header, $row);

            foreach ($data as $key =>$value){
                    if ($key !== 'Label'){
                        $data[$key] = (float) $value;
                    }
                }

            DataEkstraksi::create($data);
            $count++;
        }

        fclose($file);
        return ['success' => true];
    }

    function deleteData($nama){
        return DataEkstraksi::where('Label', $nama)->delete();
    }
}
