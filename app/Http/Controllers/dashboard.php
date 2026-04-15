<?php

namespace App\Http\Controllers;

use App\Models\log_klasifikasi;
use \Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Carbon\Carbon;

class dashboard extends Controller
{
    private function getTotalLaporan($data){
        /** @var Collection $data */
        return $data->count();
    }
    private function getLokasiTerpantau($data){
        /** @var Collection $data */
        return $data->pluck('lokasi.kecamatan')->unique()->count();
    }
    private function getAkurasi($data){
        /** @var Collection $data */
        $hasil = $data->sum('keyakinan_model') / $data->count();
        return $hasil;
    }
    private function getStatistikLabel($data){
        /** @var Collection $data */
        return $data->groupBy('hasil_label')->map->count();
    }
    private function getStatistikHarian($data){
        /** @var Collection $data */
        return $data->groupBy('created_at')->map->count();
    }

    function index(Request $req){
        $start = Carbon::parse($req->waktu_mulai)->startOfMonth();
        $end = Carbon::parse($req->waktu_akhir)->endOfMonth();

        $dataMentah = log_klasifikasi::whereBetween('created_at', [$start, $end])
        ->get([
            'lokasi', 'keyakinan_model',
            'hasil_label', 'created_at'
            ]);

        return response()->json([
            'message'=>true, 'data'=> [
                'data_tabel'=> $dataMentah,
                'ringkasan_total'=> $this->getTotalLaporan($dataMentah),
                'ringkasan_lokasi' => $this->getLokasiTerpantau($dataMentah),
                'ringkasan_akurasi'=> $this->getAkurasi($dataMentah),
                'ringkasan_label' => $this->getStatistikLabel($dataMentah),
                'ringkasan_harian' => $this->getStatistikHarian($dataMentah)
            ]
        ]);
    }

    function visualisasiLokasi(Request $req){
        $req->validate(['tahun'=>'required|numeric|min:2010']);

        $dataMentah = log_klasifikasi::whereYear('created_at', $req->tahun);
        $jmlKabupaten = $dataMentah->groupBy('lokasi.kabupaten')->map->count();
        $statistikKec = $dataMentah->groupBy('lokasi.kecamatan')->map->count();
        
        return response()->json([
            'message'=>true, 'data'=>[
                'statistik_kabupaten' => $jmlKabupaten,
                'visual_kecamatan' => $statistikKec
            ]
        ]);
    }
}
