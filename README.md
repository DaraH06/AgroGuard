<div align="center">
  <img src="https://images.weserv.nl/?url=raw.githubusercontent.com/laravel/art/master/logo-lockup/5%2520SVG/2%2520CMYK/1%2520Full%2520Color/laravel-logolockup-cmyk-red.svg&w=400" alt="AgroGuard Admin Logo" width="150"/>
  <h1>🛡️ AgroGuard Admin 🌾</h1>
  <p><em>Dashboard Admin untuk Monitoring & Manajemen Data Penyakit Tanaman Padi.</em></p>

[![Laravel](https://img.shields.io/badge/Laravel-^12.0-FF2D20?logo=laravel&logoColor=white)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-^8.2-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![MongoDB](https://img.shields.io/badge/MongoDB-Database-47A248?logo=mongodb&logoColor=white)](https://www.mongodb.com/)
[![Flask](https://img.shields.io/badge/Flask-3.x-000000?logo=flask&logoColor=white)](https://flask.palletsprojects.com/)
[![Python](https://img.shields.io/badge/Python-^3.10-3776AB?logo=python&logoColor=white)](https://www.python.org/)
[![Vite](https://img.shields.io/badge/Vite-^7.0-646CFF?logo=vite&logoColor=white)](https://vitejs.dev/)
[![Repo](https://img.shields.io/badge/Repository-GitHub-181717?logo=github)](https://github.com/Darah06/AgroGuard-admin)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

</div>

---

## 📖 Tentang Projek

**AgroGuard Admin** adalah monorepo yang terdiri dari dua komponen utama dalam ekosistem AgroGuard:

1. **`AgroGuard-Admin`** — Dashboard web berbasis **Laravel** sebagai pusat kendali bagi admin untuk memantau, menganalisis, dan mengelola data penyakit tanaman padi yang dikirimkan dari aplikasi mobile.
2. **`AgroGuard-Model`** — Server **Flask (Python)** yang menjalankan model KNN untuk klasifikasi penyakit tanaman padi berdasarkan fitur gambar.

---

## ✨ Fitur Utama

- 📊 **Dashboard Analitik**: Visualisasi data penyakit tanaman secara real-time menggunakan Chart.js dengan grafik interaktif.
- 🗺️ **Peta Sebaran**: Tampilan peta sebaran penyakit berdasarkan data geolokasi dari laporan lapangan.
- 🦠 **Manajemen Penyakit (CRUD)**: Fitur lengkap untuk menambah, melihat, mengubah, dan menghapus data penyakit.
- 👤 **Manajemen User**: Pengelolaan akun pengguna dengan kontrol akses berbasis autentikasi.
- 📥 **Data Export**: Ekspor data laporan ke format Excel (`.xlsx`) untuk analisis lanjutan.
- 🔗 **API Integration**: Menerima data upload gambar dan metadata dari aplikasi [AgroGuard Mobile](https://github.com/Darah06/AgroGuard-mobile).
- 🤖 **AI Klasifikasi**: Integrasi dengan Flask AI server untuk klasifikasi penyakit padi menggunakan model KNN.
- 🔐 **Autentikasi**: Sistem login yang aman dengan fitur forgot password.
- 🎨 **UI Modern**: Antarmuka admin yang responsif dan premium menggunakan Tailwind CSS & Alpine.js.

---

## 🛠️ Tech Stack

| Layer         | Teknologi                                                                    |
| ------------- | ---------------------------------------------------------------------------- |
| **Backend**   | [Laravel 12](https://laravel.com/)                                           |
| **Database**  | [MongoDB](https://www.mongodb.com/) via `mongodb/laravel-mongodb`            |
| **Frontend**  | [Tailwind CSS](https://tailwindcss.com/), [Alpine.js](https://alpinejs.dev/) |
| **Charting**  | [Chart.js](https://www.chartjs.org/)                                         |
| **Bundler**   | [Vite](https://vitejs.dev/)                                                  |
| **Export**    | [SimpleXLSXGen](https://github.com/shuchkin/simplexlsxgen)                   |
| **AI Server** | [Flask](https://flask.palletsprojects.com/) + [scikit-learn](https://scikit-learn.org/) (KNN) |
| **Vision**    | [OpenCV](https://opencv.org/), [scikit-image](https://scikit-image.org/), [Pillow](https://pillow.readthedocs.io/) |
| **Language**  | PHP ^8.2, Python ^3.10                                                       |

---

## 📁 Struktur Projek (Monorepo)

```
AgroGuard-admin/          ← Root repository ini
├── AgroGuard-Admin/      ← Aplikasi Laravel (Dashboard Web)
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   ├── autentikasi.php           # Auth controller
│   │   │   ├── crud_penyakit.php         # CRUD penyakit
│   │   │   ├── dashboard.php             # Dashboard & export
│   │   │   ├── FlutterImageController.php  # API upload gambar
│   │   │   ├── KondisiController.php     # Kondisi lapangan
│   │   │   ├── ManajemenUserController.php # Manajemen user
│   │   │   ├── send_toFlask.php          # Integrasi Flask AI
│   │   │   └── serviceController.php     # Service layer
│   │   └── Models/
│   │       ├── DataEkstraksi.php
│   │       ├── FlutterImage.php
│   │       ├── User.php
│   │       ├── log_klasifikasi.php
│   │       └── penyakit.php
│   ├── resources/views/
│   │   ├── admin/                        # Halaman-halaman admin
│   │   ├── auth/                         # Login & forgot password
│   │   └── layouts/                      # Layout templates
│   ├── routes/
│   │   ├── web.php                       # Web routes
│   │   └── api.php                       # API routes
│   ├── .env.example
│   └── vite.config.js
│
├── AgroGuard-Model/      ← Flask AI Server (Model KNN)
│   ├── model/
│   │   ├── knn.py                        # Algoritma KNN
│   │   ├── ekstraktor.py                 # Ekstraksi fitur gambar
│   │   ├── bgremover.py                  # Background removal
│   │   ├── knn_model.joblib              # Model terlatih
│   │   ├── scaler.joblib                 # Scaler fitur
│   │   └── label.joblib                  # Label encoder
│   ├── app.py                            # Entry point Flask
│   ├── kontroller.py                     # Koneksi DB & load model
│   ├── requirements.txt
│   └── .env.example
│
├── LICENSE
└── README.md
```

---

## 🚀 Persiapan Menjalankan Projek

Projek ini terdiri dari **dua service** yang harus dijalankan secara bersamaan. Ikuti panduan di bawah ini secara berurutan.

### Prasyarat Global

Pastikan semua tools berikut sudah terinstall di sistem Anda:

- **PHP** >= 8.2
- **Composer**
- **Node.js** & NPM
- **MongoDB** (lokal atau MongoDB Atlas)
- **Python** >= 3.10
- **Git**

---

## ⚙️ Bagian 1: AgroGuard-Admin (Laravel)

### Instalasi

```bash
# 1. Clone repositori ini
git clone https://github.com/Darah06/AgroGuard-admin.git
cd AgroGuard

# 2. Masuk ke folder Laravel
cd AgroGuard-Admin

# 3. Install dependensi PHP
composer install

# 4. Salin file environment
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Install dependensi NPM
npm install

# 7. Build assets frontend
npm run build
```

### Konfigurasi `.env`

Buka file `AgroGuard-Admin/.env` dan sesuaikan nilai berikut:

```env
# Koneksi MongoDB
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=agrodb
DB_USERNAME=          # Kosongkan jika tidak pakai autentikasi
DB_PASSWORD=          # Kosongkan jika tidak pakai autentikasi

# Koneksi ke Flask AI Server (sesuaikan dengan port Flask kamu)
FLASK_KEY=your_secret_api_key_here
FLASK_HOST=localhost
FLASK_PORT=5000
```

> ⚠️ **Penting:** Nilai `FLASK_KEY` di sini **harus sama persis** dengan `INTERNAL_API_KEY` yang ada di `.env` milik `AgroGuard-Model`.

### Menjalankan Server Laravel

```bash
# Dari dalam folder AgroGuard-Admin/

# Opsi 1: Jalankan semua service sekaligus (server, queue, logs, vite)
composer run dev

# Opsi 2: Jalankan manual di terminal terpisah
php artisan serve        # Laravel server
npm run dev              # Vite dev server
```

Akses dashboard melalui: `http://localhost:8000/login`

---

## 🤖 Bagian 2: AgroGuard-Model (Flask AI Server)

Service ini adalah server Python yang memuat model KNN dan menyediakan endpoint untuk klasifikasi gambar penyakit padi.

### Instalasi

```bash
# Dari root repository, masuk ke folder model
cd AgroGuard-Model

# 1. Buat virtual environment Python
python -m venv venv

# 2. Aktifkan virtual environment
venv\Scripts\activate

# 3. Install semua dependensi Python
pip install -r requirements.txt
```

Perintah di atas akan menginstall semua library yang dibutuhkan. Berikut library-library utamanya:

| Library              | Versi        | Fungsi                                              |
| -------------------- | ------------ | --------------------------------------------------- |
| `Flask`              | 3.1.3        | Web framework untuk API server                      |
| `scikit-learn`       | 1.8.0        | Model KNN & preprocessing (StandardScaler)          |
| `joblib`             | 1.5.3        | Menyimpan & memuat model terlatih (`.joblib`)       |
| `opencv-python`      | 4.13.0.92    | Pemrosesan gambar (segmentasi, analisis warna)      |
| `scikit-image`       | 0.26.0       | Ekstraksi fitur tekstur gambar                      |
| `Pillow`             | 12.2.0       | Membaca & manipulasi file gambar                    |
| `numpy`              | 2.4.4        | Komputasi numerik & array                           |
| `pandas`             | 3.0.2        | Manipulasi data tabular                             |
| `pymongo`            | 4.17.0       | Koneksi ke database MongoDB                         |
| `python-dotenv`      | 1.2.2        | Membaca konfigurasi dari file `.env`                |
| `matplotlib`         | 3.10.9       | Visualisasi data (opsional, untuk debugging)        |

### Konfigurasi `.env`

```bash
# Salin file environment
cp .env.example .env
```

Buka file `AgroGuard-Model/.env` dan sesuaikan:

```env
# Koneksi MongoDB (sama dengan yang dipakai Laravel)
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=agrodb
DB_USERNAME=
DB_PASSWORD=

# API Key untuk keamanan endpoint Flask
# Nilai ini HARUS SAMA dengan FLASK_KEY di .env milik AgroGuard-Admin
INTERNAL_API_KEY=your_secret_api_key_here
```

### Menjalankan Flask Server

Pastikan virtual environment sudah aktif (ada `(venv)` di awal terminal kamu), lalu:

```bash
# Dari dalam folder AgroGuard-Model/
flask run
```

Flask akan berjalan di: `http://localhost:5000`

> 💡 **Tips:** Biarkan terminal Flask tetap berjalan selama kamu menggunakan fitur AI di dashboard admin.

### Endpoint Flask API

| Method | Endpoint          | Deskripsi                                           |
| ------ | ----------------- | --------------------------------------------------- |
| `POST` | `/ekstrak`        | Mengklasifikasikan gambar berdasarkan path foto     |
| `POST` | `/refresh_model`  | Me-refresh/reload model KNN dari database           |
| `POST` | `/proses-dataset` | Memproses folder gambar dataset untuk training      |

Semua endpoint memerlukan header:
```
X-API-KEY: your_secret_api_key_here
```

---

## 🔄 Alur Kerja Sistem

```
[AgroGuard Mobile] ──upload gambar──▶ [AgroGuard-Admin / Laravel]
                                              │
                                    simpan gambar ke storage
                                              │
                                    kirim path ke Flask via HTTP
                                              ▼
                                    [AgroGuard-Model / Flask]
                                              │
                                    ekstrak fitur gambar (OpenCV)
                                              │
                                    klasifikasi dengan model KNN
                                              │
                                    kembalikan hasil ke Laravel
                                              ▼
                                    [Dashboard Admin] tampilkan hasil
```

---

## 🤝 Kontributor

Terima kasih kepada anggota kelompok saya yang telah berkontribusi:

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<table align="center">
  <tr>
    <td align="center" width="160">
      <a href="https://github.com/Darah06">
        <img src="https://images.weserv.nl/?url=github.com/Darah06.png&w=120&h=120&fit=cover&mask=circle" width="100" alt="Darah06"/><br />
        <sub><b>Darah06</b></sub>
      </a><br />
      <sub>💻 🎨 📖</sub>
    </td>
    <td align="center" width="160">
      <a href="https://github.com/7-hikari">
        <img src="https://images.weserv.nl/?url=github.com/7-hikari.png&w=120&h=120&fit=cover&mask=circle" width="100" alt="7-hikari"/><br />
        <sub><b>7-hikari</b></sub>
      </a><br />
      <sub>💻 📖</sub>
    </td>
    <td align="center" width="160">
      <a href="https://github.com/">
        <img src="https://images.weserv.nl/?url=github.com/inihilmyloh.png&w=120&h=120&fit=cover&mask=circle" width="100" alt="inihilmyloh"/><br />
        <sub><b>inihilmyloh</b></sub>
      </a><br />
      <sub>💻📖</sub>
    </td>
    <td align="center" width="160">
      <a href="https://github.com/riskaazizah26">
        <img src="https://images.weserv.nl/?url=github.com/riskaazizah26.png&w=120&h=120&fit=cover&mask=circle" width="100" alt="riskaazizah26"/><br />
        <sub><b>riskaazizah26</b></sub>
      </a><br />
      <sub>💻🎨</sub>
    </td>
    <td align="center" width="160">
      <a href="https://github.com/ahmadrifai-gan">
        <img src="https://images.weserv.nl/?url=github.com/ahmadrifai-gan.png&w=120&h=120&fit=cover&mask=circle" width="100" alt="ahmadrifai-gan"/><br />
        <sub><b>ahmadrifai-gan</b></sub>
      </a><br />
      <sub>💻🎨</sub>
    </td>
  </tr>
</table>

## 📄 Lisensi

Proyek ini dilisensikan di bawah **MIT License** - lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.

---

<div align="center">
  <i>Dikembangkan dengan ❤️ oleh Tim AgroGuard untuk masa depan pertanian yang lebih cerdas.</i>
</div>
