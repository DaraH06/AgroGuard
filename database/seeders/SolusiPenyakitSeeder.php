<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\penyakit;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SolusiPenyakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hati-hati: ini akan mencoba membersihkan koleksi `penyakit` terlebih dahulu.
        try {
            penyakit::truncate();

            $diseases = config('konstanta.diseases');

        foreach ($diseases as $key => $disease){
            penyakit::create([
                'thumbnail' => "contoh.jpg",
                'nama_penyakit' => $key,
                'nama_ilmiah' => $disease,
                'deskripsi' => config('konstanta.solusi')[$key]['deskripsi'],
                'penanganan' => config('konstanta.solusi')[$key]['penanganan'],
                'penanggulangan' => config('konstanta.solusi')[$key]['penanggulangan'],
                'jumlah dataset' => 438
            ]);
        }
        } catch (\Exception $e) {
            // Jika truncate tidak didukung, lanjutkan tanpa error
        }
    }
}
