<?php

return [
    'bulan' => [
        1=> 'Januari',
        2=> 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ],
    'daerah' => [
        'Jember' => ['Patrang', 'Kaliwates', 'Sumbersari'],
        'Situbondo' => ['Situbondo', 'Besuki', 'Panarukan'],
        'Lumajang' => ['Sukodono', 'Kedungjajang', 'Jatiroto'],
        'Bondowoso' => ['Tamanan', 'Ijen', 'Wonosari'],
        'Banyuwangi' => ['Genteng', 'Banyuwangi', 'Gambiran']
    ],

    'diseases' => ['Healthy', 'Bacterial Leaf Blight', 'Brown Spot', 'Leaf Scald', 'Leaf Blast', 'Narrow Brown Spot'],

    'solusi' => [
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
            'Healthy' => [
                'penanganan' => [],
                'penanggulangan' => [],
            ],
            ]
];
