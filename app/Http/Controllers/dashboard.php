<?php

namespace App\Http\Controllers;

use App\Models\log_klasifikasi;
use \Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
        $hasil = round($data->sum('keyakinan_model') / $data->count(), 2);
        logger()->info('sesi', session()->all());
        return $hasil;
    }
    private function getStatistikLabel($data){
        /** @var Collection $data */
        return $data->groupBy('hasil_label')->map->count();
    }
    private function getStatistikHarian($data){
        /** @var Collection $data */
        return $data->groupBy(function($item){
            return $item->created_at->format('Y-m-d');
            })->map->count();
    }

    function index(Request $req){
        $start = Carbon::parse($req->bulan_mulai)->startOfMonth();
        $end = Carbon::parse($req->bulan_akhir)->endOfMonth();

        /** @var Collection $dataMentah */

        $dataMentah = log_klasifikasi::whereBetween('created_at', [$start, $end])
        ->project(['_id'=>0])->orderBy('created_at', 'asc')
        ->get([
            'lokasi', 'keyakinan_model',
            'hasil_label', 'created_at'
            ]);

        $status = filled($dataMentah);

        if(!$status)return response()->json(['status'=>false, 'data'=>null]);

        return response()->json([
            'status'=>$status, 'data'=> [
                'data_tabel'=> $dataMentah->sortByDesc('created_at')->take(20)->values(),
                'total'=> $this->getTotalLaporan($dataMentah),
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
            'status'=>true, 'data'=>[
                'statistik_kabupaten' => $jmlKabupaten,
                'visual_kecamatan' => $statistikKec
            ]
        ]);
    }
}
