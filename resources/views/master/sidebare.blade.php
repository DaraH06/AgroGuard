<div class="sidebar-wrapper d-flex flex-column"
    style="height: 100vh; padding: 20px; background-color: #ffffff; border-right: 1px solid #e5e7eb;">

    <div class="sidebar-header mb-1">
        <h3 style="display: flex; align-items: center; gap: 8px; color: #2b5e3b; margin: 0; font-weight: 700;">
            <img src="{{ asset('assets/image/logo.svg') }}" alt="Logo"
                style="width: 45px; height: 45px; border-radius: 8px; padding: 4px;">
            AgroGuard
        </h3>
    </div>

    <div class="menu-label"
        style="color: #94a3b8; font-size: 14px; margin: 10px 0 12px 0; letter-spacing: 1.2px; font-weight: 800; text-transform: uppercase;">
        MENU UTAMA
    </div>

    <ul class="nav d-flex flex-column flex-grow-1" style="list-style: none; padding: 0; margin: 0; gap: 5px;">

        <li class="nav-item w-100">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}"
                style="display: flex; align-items: center; gap: 10px; text-decoration: none; padding: 12px 15px; border-radius: 10px; transition: 0.3s;
                      {{ Request::routeIs('admin.dashboard') ? 'background-color: #d1e7dd; color: #1e3a2f !important;' : 'color: #64748b;' }}">
                <i class="bi bi-grid-1x2-fill"
                    style="{{ Request::routeIs('admin.dashboard') ? 'color: #16a34a;' : 'color: #64748b;' }}"></i>
                <span style="font-weight: 500;">Dashboard</span>
            </a>
        </li>

        <li class="nav-item w-100">
            <a href="{{ route('admin.manajemen-penyakit') }}"
                class="nav-link {{ Request::routeIs('admin.manajemen-penyakit') ? 'active' : '' }}"
                style="display: flex; align-items: center; gap: 10px; text-decoration: none; padding: 12px 15px; border-radius: 10px; transition: 0.3s;
                      {{ Request::routeIs('admin.manajemen-penyakit') ? 'background-color: #d1e7dd; color: #1e3a2f !important;' : 'color: #64748b;' }}">
                <i class="bi bi-file-medical-fill"
                    style="{{ Request::routeIs('admin.manajemen-penyakit') ? 'color: #16a34a;' : 'color: #64748b;' }}"></i>
                <span style="font-weight: 500;">Manajemen Penyakit</span>
            </a>
        </li>

        <li class="nav-item w-100">
            <a href="{{ route('admin.peta-sebaran') }}"
                class="nav-link {{ Request::routeIs('admin.peta-sebaran') ? 'active' : '' }}"
                style="display: flex; align-items: center; gap: 10px; text-decoration: none; padding: 12px 15px; border-radius: 10px; transition: 0.3s;
                      {{ Request::routeIs('admin.peta-sebaran') ? 'background-color: #d1e7dd; color: #1e3a2f !important;' : 'color: #64748b;' }}">
                <i class="bi bi-map-fill"
                    style="{{ Request::routeIs('admin.peta-sebaran') ? 'color: #16a34a;' : 'color: #64748b;' }}"></i>
                <span style="font-weight: 500;">Peta Sebaran</span>
            </a>
        </li>

        <li class="nav-item w-100 mt-auto" style="margin-top: auto !important; padding-bottom: 5px;">
            <a href="#" class="nav-link logout" style="color: #f87171; 
                        display: flex; 
                        align-items: center; 
                        gap: 12px; 
                        text-decoration: none; 
                        padding: 20px 25px; 
                        font-size: 18px; 
                        font-weight: 700;
                        transition: 0.3s;">

                <i class="bi bi-box-arrow-right" style="font-size: 1.5rem;"></i>
                <span>Keluar</span>
            </a>
        </li>
    </ul>
</div>