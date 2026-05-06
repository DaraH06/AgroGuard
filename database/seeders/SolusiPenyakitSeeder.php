<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\penyakit;
use Illuminate\Support\Facades\Log;

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
            Log::info($diseases);

        foreach ($diseases as $key => $disease){
            penyakit::create([
                'nama_penyakit' => $disease,
                'penanganan' => config('konstanta.solusi')[$disease]['penanganan'],
                'penanggulangan' => config('konstanta.solusi')[$disease]['penanggulangan'],
                'jumlah dataset' => 438
            ]);
        }
        } catch (\Exception $e) {
            // Jika truncate tidak didukung, lanjutkan tanpa error
        }
    }
}
