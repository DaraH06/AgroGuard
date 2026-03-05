<!-- resources/views/master/sidebar-content.blade.php -->
<div class="sidebar-header">
    <h3 style="display: flex; align-items: center; gap: 8px;">
        <img src="{{ asset('assets/image/logo.svg') }}" 
             alt="Logo" 
             style="width: 50px; height: 50px;">

        AgroGuard
    </h3>
</div>

<div class="menu-label">MENU UTAMA</div>

<ul class="nav">
    <!-- Dashboard -->
    <li class="nav-item w-100">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span>
        </a>
    </li>
    
    <!-- Manajemen Penyakit -->
    <li class="nav-item w-100">
        <a href="#" class="nav-link">
            <i class="bi bi-file-medical-fill"></i>
            <span>Manajemen Penyakit</span>
        </a>
    </li>
    
    <!-- Peta Sebaran -->
    <li class="nav-item w-100">
        <a href="#" class="nav-link">
            <i class="bi bi-map-fill"></i>
            <span>Peta Sebaran</span>
        </a>
    </li>
    
    <!-- Keluar -->
    <li class="nav-item w-100">
        <a href="#" class="nav-link logout">
            <i class="bi bi-box-arrow-right"></i>
            <span>Keluar</span>
        </a>
    </li>
</ul>