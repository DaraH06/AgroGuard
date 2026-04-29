<?php

namespace App\Http\Controllers;

use App\Models\log_klasifikasi;
use \Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Shuchkin\SimpleXLSXGen;
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
        /** @var Collection $data 
         * @var Collection $hasil */
        
        $hasil = $data->groupBy('hasil_label')->map->count();
        $sorted = $hasil->sortBy(function ($val, $key){
            return $key === 'Healthy' ? 0 : 1;
        });
        return $sorted;
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

    function mapVisualisasi(Request $req){
        $tahun = $req->validate(['tahun'=>'required|numeric|min:2010']);

        $dataMentah = log_klasifikasi::whereYear('created_at', (int) $tahun['tahun'])
        ->project(['_id'=>0])->get();

        $statistikLabel = $dataMentah->groupBy('hasil_label')
            ->sortKeysUsing(function($a, $b){
                if($a === 'Healthy') return -1;
                if($b === 'Healthy') return 1;
                return strcasecmp($a, $b);
            });
        
        return response()->json([
            'status'=>true, 'data'=>[
                'visual_map' => $statistikLabel
            ]
        ]);
    }

    function export(Request $req){
        $req->validate(['month_year'=>'required|date_format:Y-m']);
        $start = Carbon::parse($req->month_year)->startOfMonth();
        $end = Carbon::parse($req->month_year)->endOfMonth();

        $dataMentah = log_klasifikasi::whereBetween('created_at', [$start, $end])
        ->project(['_id'=>0])->orderBy('created_at', 'desc')
        ->get([
            'lokasi', 'keyakinan_model',
            'hasil_label', 'created_at'
            ]);
        return $this->toExcel($dataMentah, $req->month_year);
    }

    private function toExcel($data, $time){
        $header = ['Tanggal',
        'Kecamatan', 'Kabupaten', 
        'Provinsi', 'Tingkat Keyakinan Model',
        'Hasil Label'];

        $dat = $data->map(function($datas){
            $lokasi = (object) $datas->lokasi;
            return [
                $datas->created_at,
                $lokasi->kecamatan,
                $lokasi->kabupaten,
                $lokasi->provinsi,
                $datas->keyakinan_model,
                $datas->hasil_label
            ];
        })->toArray();

        array_unshift($dat, $header);

        return SimpleXLSXGen::fromArray($dat)->downloadAs('');
    }
}
