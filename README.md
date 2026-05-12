<div align="center">
  <img src="https://images.weserv.nl/?url=raw.githubusercontent.com/laravel/art/master/logo-lockup/5%2520SVG/2%2520CMYK/1%2520Full%2520Color/laravel-logolockup-cmyk-red.svg&w=400" alt="AgroGuard Admin Logo" width="150"/>
  <h1>🛡️ AgroGuard Admin 🌾</h1>
  <p><em>Dashboard Admin untuk Monitoring & Manajemen Data Penyakit Tanaman Padi.</em></p>

[![Laravel](https://img.shields.io/badge/Laravel-^12.0-FF2D20?logo=laravel&logoColor=white)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-^8.2-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![MongoDB](https://img.shields.io/badge/MongoDB-Database-47A248?logo=mongodb&logoColor=white)](https://www.mongodb.com/)
[![Vite](https://img.shields.io/badge/Vite-^7.0-646CFF?logo=vite&logoColor=white)](https://vitejs.dev/)
[![Repo](https://img.shields.io/badge/Repository-GitHub-181717?logo=github)](https://github.com/Darah06/AgroGuard-admin)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

</div>

---

## 📖 Tentang Projek

**AgroGuard Admin** adalah dashboard web berbasis Laravel yang merupakan bagian dari ekosistem AgroGuard. Sistem ini berfungsi sebagai pusat kendali bagi admin untuk memantau, menganalisis, dan mengelola data penyakit tanaman padi yang dikirimkan dari aplikasi mobile. Dilengkapi dengan visualisasi data interaktif, peta sebaran penyakit, serta fitur manajemen CRUD yang lengkap.

## ✨ Fitur Utama

- 📊 **Dashboard Analitik**: Visualisasi data penyakit tanaman secara real-time menggunakan Chart.js dengan grafik interaktif.
- 🗺️ **Peta Sebaran**: Tampilan peta sebaran penyakit berdasarkan data geolokasi dari laporan lapangan.
- 🦠 **Manajemen Penyakit (CRUD)**: Fitur lengkap untuk menambah, melihat, mengubah, dan menghapus data penyakit.
- 👤 **Manajemen User**: Pengelolaan akun pengguna dengan kontrol akses berbasis autentikasi.
- 📥 **Data Export**: Ekspor data laporan ke format Excel (`.xlsx`) untuk analisis lanjutan.
- 🔗 **API Integration**: Menerima data upload gambar dan metadata dari aplikasi [AgroGuard Mobile](https://github.com/Darah06/AgroGuard-mobile).
- 🔐 **Autentikasi**: Sistem login yang aman dengan fitur forgot password.
- 🎨 **UI Modern**: Antarmuka admin yang responsif dan premium menggunakan Tailwind CSS & Alpine.js.

## 🛠️ Tech Stack

| Layer        | Teknologi                                                                    |
| ------------ | ---------------------------------------------------------------------------- |
| **Backend**  | [Laravel 12](https://laravel.com/)                                           |
| **Database** | [MongoDB](https://www.mongodb.com/) via `mongodb/laravel-mongodb`            |
| **Frontend** | [Tailwind CSS](https://tailwindcss.com/), [Alpine.js](https://alpinejs.dev/) |
| **Charting** | [Chart.js](https://www.chartjs.org/)                                         |
| **Bundler**  | [Vite](https://vitejs.dev/)                                                  |
| **Export**   | [SimpleXLSXGen](https://github.com/shuchkin/simplexlsxgen)                   |
| **Language** | PHP ^8.2                                                                     |

## 🚀 Persiapan Menjalankan Projek

Ikuti langkah-langkah berikut untuk menjalankan projek di lingkungan lokal Anda:

### Prasyarat

- PHP >= 8.2
- Composer
- Node.js & NPM
- MongoDB (lokal atau Atlas)
- Git

### Instalasi

```bash
# 1. Clone repositori
git clone https://github.com/Darah06/AgroGuard-admin.git
cd AgroGuard-admin

# 2. Install dependensi PHP
composer install

# 3. Salin file environment
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Konfigurasi koneksi MongoDB di file .env
#    Sesuaikan DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE

# 6. Install dependensi NPM
npm install

# 7. Build assets
npm run build
```

### Menjalankan Server

```bash
# Opsi 1: Jalankan semua service sekaligus (server, queue, logs, vite)
composer run dev

# Opsi 2: Jalankan manual
php artisan serve        # Laravel server
npm run dev              # Vite dev server
```

Akses dashboard melalui: `http://localhost:8000/login`

## 📁 Struktur Projek

```
AgroGuard-admin/
├── app/
│   ├── Http/Controllers/
│   │   ├── autentikasi.php          # Auth controller
│   │   ├── crud_penyakit.php        # CRUD penyakit
│   │   ├── dashboard.php            # Dashboard & export
│   │   ├── FlutterImageController.php # API upload gambar
│   │   ├── ManajemenUserController.php # Manajemen user
│   │   └── send_toFlask.php         # Integrasi Flask AI
│   └── Models/
├── resources/views/
│   ├── admin/
│   │   ├── dashboard/               # Halaman dashboard
│   │   ├── manajemenPenyakit/       # CRUD penyakit
│   │   ├── manajemenUser/           # Manajemen user
│   │   └── peta/                    # Peta sebaran
│   ├── auth/                        # Login & forgot password
│   └── layouts/                     # Layout templates
├── routes/
│   ├── web.php                      # Web routes
│   └── api.php                      # API routes
└── vite.config.js                   # Vite configuration
```

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
