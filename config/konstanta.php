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

    'diseases' => ['Healthy' => "",
                    'Bacterial Leaf Blight' => 'Xanthomonas oryzae pv. oryzae',
                    'Brown Spot' => 'Bipolaris oryzae',
                    'Leaf Scald' => 'Microdochium oryzae',
                    'Leaf Blast' => 'Pyricularia oryzae Cavara',
                    'Narrow Brown Spot' => 'Cercospora janseana'],

    'solusi' => [
            'Bacterial Leaf Blight' => [
                'deskripsi' => [
                    'Penyakit ini menyebabkan daun padi menguning, mengering, dan pada fase awal dapat menyebabkan bibit mati mendadak yang dikenal dengan istilah kresek.',
                    'Dimulai dari tepi daun dengan bintik baisah, berubah menjadi keabu-abuan atau kekuningan, dan akhirnya daun mengering.',
                    'Penyakit ini berkembang pesat di daerah dengan kelembapan tinggi, curah hujan tinggi, dan sering terjadi saat musim hujan.',
                ],
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
                'deskripsi' => [
                    'Penyakit yang disebabkan oleh jamur dan sering dikaitkan dengan tanah kurang subur (defisiensi nutrisi).',
                    'Muncul bercak cokelat kecil pada daun yang kemudian membesar menjadi oval, dengan titik pusat berwarna abu-abu atau putih serta tepi kemerahan.',
                    'Serangan parah menyebabkan daun kering, gabah kopong',
                    'Jamur Bipolaris oryzae bertahan pada sisa-sisa tanaman/jerami dan ditularkan melalui benih. Sering terjadi pada kondisi kelembaban tinggi dan suhu 25-30°C.'
                ],
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
                'deskripsi' => [
                    'Penyakit yang disebabkan oleh jamur dan umumnya menyerang saat fase vegetatif (daun) dan terkadang menyebabkan patah leher pada fase generatif.',
                    'Ditandai dengan bercak berbentuk belah ketupat berwarna cokelat dengan tepi runcing dan pusat abu-abu pada daun.',
                    'Penyakit ini berkembang cepat pada lingkungan lembap, penggunaan pupuk nitrogen berlebih, dan sering menyerang padi gogo maupun sawah.'
                ],
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
                'deskripsi' => [
                    'Dikenal juga sebagai Lepuh Daun, disebabkan oleh jamur yang menyebabkan bercak-bercak seperti terbakar (melepuh).',
                    'Bercak dimulai dari ujung atau tepi daun, menunjukkan pola khas seperti "terbakar" yang meluas berwarna coklat tua dan terang dan dikelilingi area yang menguning.',
                    'Berkembang lebih cepat pada daun yang terluka dan lebih sering terjadi di lingkungan yang lembap serta pada tanaman yang kekurangan nutrisi.',
                    'Infeksi dapat berasal dari benih yang terinfeksi atau tunggul tanaman dari panen sebelumnya.'
                ],
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
                'deskripsi' => [
                    'Penyakit jamur yang menyerang daun dan pelepah tanaman padi.',
                    'Muncul pola seperti garis/elips sempit berwarna cokelat tua atau kemerahan yang sejajar dengan tulang daun berukuran (2-10 x 1-2) mm.',
                    'Umumnya terjadi di tanah yang kekurangan kalium (K) dengan suhu di sekitar berada di kisaran 25 - 28 C.'
                ],
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
                'deskripsi' => [],
                'penanganan' => [],
                'penanggulangan' => [],
            ],
            ]
];
