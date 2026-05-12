<?php

namespace App\Http\Controllers;

use App\Models\log_klasifikasi;
use App\Models\penyakit;
use Illuminate\Http\Request;

class KondisiController extends Controller
{
    /**
     * Ambil data kondisi penyakit sekitar untuk Flutter.
     * 
     * Query parameter opsional:
     *   - kabupaten: filter berdasarkan kabupaten pengguna
     * 
     * Response: daftar penyakit dikelompokkan per kecamatan,
     * diurutkan berdasarkan nama penyakit (A-Z) lalu jumlah kasus (terbanyak dulu).
     */
    public function index(Request $request)
    {
        $query = log_klasifikasi::where('hasil_label', '!=', 'Healthy');

        // Filter berdasarkan kabupaten jika ada
        if ($request->has('kabupaten')) {
            $query->where('lokasi.kabupaten', $request->query('kabupaten'));
        }

        $data = $query->orderBy('created_at', 'desc')
            ->project(['_id' => 0])
            ->get(['hasil_label', 'lokasi', 'keyakinan_model', 'created_at']);

        // Ambil thumbnail per penyakit dari collection penyakit
        $thumbnails = penyakit::pluck('thumbnail', 'nama_penyakit');

        // Group by penyakit + kecamatan (karena sudah difilter per kabupaten)
        $grouped = $data->groupBy(function ($item) {
            $kec = $item->lokasi['kecamatan'] ?? 'Tidak diketahui';
            return $item->hasil_label . '|' . $kec;
        })->map(function ($items, $key) use ($thumbnails) {
            $parts = explode('|', $key);
            $nama = $parts[0];
            $first = $items->first();
            $lokasi = $first->lokasi;

            // Buat URL thumbnail dari collection penyakit
            $thumb = $thumbnails[$nama] ?? 'contoh.jpg';
            $thumbUrl = asset("images/{$thumb}");

            return [
                'nama_penyakit' => $nama,
                'kabupaten' => $lokasi['kabupaten'] ?? '-',
                'kecamatan' => $lokasi['kecamatan'] ?? '-',
                'provinsi' => $lokasi['provinsi'] ?? '-',
                'jumlah_kasus' => $items->count(),
                'terakhir' => $first->created_at?->format('d M Y') ?? '-',
                'thumbnail_url' => $thumbUrl,
            ];
        })->sortBy([
            ['nama_penyakit', 'asc'],
            ['jumlah_kasus', 'desc']
        ])->values();

        return response()->json(['success' => true, 'data' => $grouped]);
    }
}
