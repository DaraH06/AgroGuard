<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\penyakit;

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
        } catch (\Exception $e) {
            // Jika truncate tidak didukung, lanjutkan tanpa error
        }

        \Illuminate\Database\Eloquent\Model::unguard();

        $diseases = [
            'Bacterial Leaf Blight',
            'Brown Spot',
            'Leaf Blast',
            'Leaf Scald',
            'Narrow Brown Spot',
        ];

        // Template arrays untuk penanganan dan penanggulangan (masing-masing beberapa opsi)
        $templates = [
            'Bacterial Leaf Blight' => [
                'penanganan' => [
                    'Semprotkan bakterisida berbasis tembaga sesuai dosis anjuran dan tutup area yang disemprot agar efektif.',
                    'Potong dan musnahkan bagian tanaman yang parah untuk mencegah sumber inokulum; bersihkan peralatan pemotongan sebelum digunakan lagi.',
                    'Jika serangan meluas, konsultasikan dengan penyuluh untuk rekomendasi produk kimia yang berizin.'
                ],
                'penanggulangan' => [
                    'Lakukan sanitasi lahan dan buang sisa tanaman terinfeksi; rotasi tanaman untuk mengurangi inokulum.',
                    'Gunakan benih bebas penyakit dan terapkan isolasi pada area baru untuk mencegah penyebaran.',
                ],
            ],
            'Brown Spot' => [
                'penanganan' => [
                    'Aplikasikan fungisida sistemik sesuai petunjuk dan buang daun yang telah terinfeksi berat.',
                    'Perbaiki sirkulasi udara dengan pengaturan jarak tanam agar daun cepat kering setelah hujan.'
                ],
                'penanggulangan' => [
                    'Perbaiki drainase lahan dan lakukan rotasi tanaman untuk mengurangi jumlah patogen di tanah.',
                    'Tingkatkan kesehatan tanaman melalui pemupukan seimbang untuk mengurangi keparahan penyakit.'
                ],
            ],
            'Leaf Blast' => [
                'penanganan' => [
                    'Semprot fungisida yang direkomendasikan segera setelah gejala muncul, ulangi sesuai interval label.',
                    'Lakukan penyulaman pada area yang sangat terserang untuk menurunkan sumber inokulum.'
                ],
                'penanggulangan' => [
                    'Pilih varietas padi yang tahan terhadap blast dan hindari pemupukan nitrogen berlebih.',
                    'Kelola air dengan baik; hindari genangan yang memperburuk penyebaran spora.'
                ],
            ],
            'Leaf Scald' => [
                'penanganan' => [
                    'Aplikasikan fungisida kontak pada pagi atau sore hari dan pangkas bagian tanaman yang terinfeksi berat.',
                    'Jaga kebersihan peralatan agar tidak menjadi media penyebaran penyakit.'
                ],
                'penanggulangan' => [
                    'Perbaiki praktik irigasi sehingga media tidak terlalu lembap; lakukan sanitasi lahan.',
                    'Buat rotasi tanaman dan amandemen tanah untuk memperbaiki ketahanan tanaman.'
                ],
            ],
            'Narrow Brown Spot' => [
                'penanganan' => [
                    'Semprot fungisida yang cocok dan singkirkan sisa tanaman yang mengandung patogen.',
                    'Terapkan perlakuan benih jika diperlukan untuk mengurangi inokulum awal.'
                ],
                'penanggulangan' => [
                    'Rotasi tanaman dan tambah bahan organik untuk meningkatkan kesehatan tanah.',
                    'Hindari stres tanaman akibat kekurangan nutrisi agar lebih tahan terhadap serangan.'
                ],
            ],
        ];

        $total = 800;
        $countDiseases = count($diseases);
        $perDisease = intdiv($total, $countDiseases);
        $created = 0;

        foreach ($diseases as $d) {
            for ($i = 0; $i < $perDisease; $i++) {
                $idx = $created + 1;
                // Pilih variasi template secara bergantian untuk memberi variasi data
                $pChoices = $templates[$d]['penanganan'];
                $pgChoices = $templates[$d]['penanggulangan'];
                $pText = $pChoices[$i % count($pChoices)] . " (contoh #$idx)";
                $pgText = $pgChoices[$i % count($pgChoices)] . " (contoh #$idx)";

                $data = [
                    'nama_penyakit' => $d,
                    'inang' => 'Padi',
                    // simpan sebagai array agar tiap record punya koleksi penanganan/penanggulangan
                    'penanganan' => [$pText],
                    'penanggulangan' => [$pgText],
                ];

                penyakit::create($data);
                $created++;
            }
        }

        // tambahkan sisa jika ada
        $remainder = $total - $created;
        for ($r = 0; $r < $remainder; $r++) {
            $idx = $created + 1;
            $d = $diseases[$r % $countDiseases];
            $pChoices = $templates[$d]['penanganan'];
            $pgChoices = $templates[$d]['penanggulangan'];
            $pText = $pChoices[$created % count($pChoices)] . " (contoh #$idx)";
            $pgText = $pgChoices[$created % count($pgChoices)] . " (contoh #$idx)";
            penyakit::create([
                'nama_penyakit' => $d,
                'inang' => 'Padi',
                'penanganan' => [$pText],
                'penanggulangan' => [$pgText],
            ]);
            $created++;
        }

        \Illuminate\Database\Eloquent\Model::reguard();
    }
}
