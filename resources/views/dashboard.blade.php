@extends('layouts.app')

@section('content')
<h1>Dashboard AgroGuard</h1>

<div class="cards">

    <!-- CARD 1 -->
    <div class="card">
        <div class="card-icon green">📊</div>
        <div>
            <p>Total Scan Sistem</p>
            <h2>8,432</h2>
        </div>
    </div>

    <!-- CARD 2 -->
    <div class="card">
        <div class="card-icon blue">🛡️</div>
        <div>
            <p>Akurasi Model AI</p>
            <h2>94.2%</h2>
        </div>
    </div>

    <!-- CARD 3 -->
    <div class="card">
        <div class="card-icon orange">🐛</div>
        <div>
            <p>Hama Teridentifikasi</p>
            <h2>24</h2>
        </div>
    </div>

    <!-- CARD 4 -->
    <div class="card">
        <div class="card-icon red">⚠️</div>
        <div>
            <p>Anomali Data</p>
            <h2>3</h2>
        </div>
    </div>

</div>

<div class="dashboard-bottom">
    <div class="trend-box">
        <h3>Tren Deteksi Mingguan</h3>
        <canvas id="lineChart"></canvas>
    </div>

    <div class="distribusi-box">
    <h3>Distribusi Komoditas</h3>
    <canvas id="barChart"></canvas>

    <!-- KESEHATAN DATABASE -->
    <div class="db-health-wrapper">
        <div class="db-health-header">
            <span>Kesehatan Database</span>
            <span class="db-percent">92%</span>
        </div>

        <div class="db-progress">
            <div class="db-progress-fill" style="width:92%;"></div>
        </div>
    </div>

    <!-- SINKRONISASI -->
    <div class="sync-text">
        Sinkronisasi terakhir: 2 menit yang lalu
    </div>
</div>
</div>

<div class="dashboard-footer">
    <div class="storage-box">
        <h3>Status Penyimpanan</h3>

        <div class="storage-item">
            <span>Metadata Scan</span>
            <span>12.4 GB</span>
        </div>

        <div class="storage-item">
            <span>Dataset Gambar</span>
            <span>45.8 GB</span>
        </div>

        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>

        <small>Total Terpakai 58.2 / 100 GB</small>
    </div>

    <div class="map-box">
        <h3>Pantau Peta Sebaran</h3>
        <p>
            Lihat titik deteksi secara geografis untuk mengambil
            kebijakan antisipasi serangan hama di tingkat desa.
        </p>

        <button class="btn-map">Buka Peta GIS</button>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const lineCanvas = document.getElementById('lineChart');
    const barCanvas = document.getElementById('barChart');

    if (lineCanvas) {
        new Chart(lineCanvas, {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [
                    {
                        label: 'Total Scan',
                        data: [45, 52, 38, 65, 48, 72, 60],
                        borderColor: '#16a34a',
                        backgroundColor: 'rgba(22,163,74,0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Positif Hama',
                        data: [12, 18, 8, 24, 15, 32, 20],
                        borderColor: '#f97316',
                        backgroundColor: 'rgba(249,115,22,0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: { responsive: true }
        });
    }

    if (barCanvas) {
        new Chart(barCanvas, {
            type: 'bar',
            data: {
                labels: ['Padi', 'Jagung', 'Kedelai', 'Cabai'],
                datasets: [{
                    label: 'Jumlah Deteksi',
                    data: [60, 45, 25, 15],
                    backgroundColor: [
                        '#16a34a',
                        '#facc15',
                        '#3b82f6',
                        '#ef4444'
                    ],
                    borderRadius: 8
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: { legend: { display: false } }
            }
        });
    }

});
</script>

@endsection