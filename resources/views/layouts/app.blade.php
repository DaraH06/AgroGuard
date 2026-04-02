<!DOCTYPE html>
<html>
<head>
    <title>AgroGuard Admin</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <!-- LOGO -->
        <div class="logo">
            <div class="logo-icon">🌿</div>
            <h2>AgroGuard</h2>
        </div>

        <p class="menu-title">MENU UTAMA</p>

        <ul class="menu">
            <li class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <span>📊</span>
                <a href="/dashboard">Dashboard</a>
            </li>

            <li class="menu-item">
                <span>🦠</span>
                <a href="#">Manajemen Penyakit</a>
            </li>

            <li class="menu-item">
                <span>🗺️</span>
                <a href="#">Peta Sebaran</a>
            </li>
        </ul>

        <div class="spacer"></div>

        <div class="keluar">
            <span>🚪</span>
            <a href="#">Keluar</a>
        </div>

    </aside>

    <!-- CONTENT -->
    <main class="content">

        <!-- HEADER -->
        <div class="header">
            <input type="text" placeholder="Cari data, laporan, atau hama..." class="search">

            <div class="header-right">
                <span class="notif">🔔</span>
                <div class="profile">
                    <strong>Dr. Ahmad Faisal</strong>
                    <small>Ahli Tanaman Senior</small>
                </div>
            </div>
        </div>

        @yield('content')

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>