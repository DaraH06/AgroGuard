<!-- resources/views/master/sidebar.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AgroGuard - Sistem Informasi Penyakit Tanaman</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/image/ikon.png') }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Font: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @stack('style')

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', system-ui, -apple-system, sans-serif;
        }

        #wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        /* Sidebar Styles */
        #sidebar-wrapper {
            min-width: 280px;
            max-width: 280px;
            background: #ffff;
            color: #fff;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .sidebar-header {
            padding: 25px 20px 15px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        .sidebar-header h3 {
            margin: 0;
            font-weight: 600;
            font-size: 24px;
            letter-spacing: 0.5px;
            color: #000000;
        }

        .sidebar-header h3 i {
            margin-right: 10px;
            color: #ffd966;
        }

        .menu-label {
            padding: 20px 20px 8px 20px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(0, 0, 0, 0.5);
            font-weight: 500;
        }

        .nav {
            flex-direction: column;
            padding: 0 10px;
        }

        .nav-item {
            margin: 4px 0;
        }

        .nav-link {
            color: rgba(68, 67, 67, 0.85);
            padding: 12px 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            font-weight: 500;
        }

        .nav-link i {
            margin-right: 12px;
            font-size: 1.3rem;
            width: 24px;
            text-align: center;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: #bd2222;
            transform: translateX(5px);
        }

        .nav-link.active {
            background-color: #C8D3CE;
            color: #1e4a2c;
            font-weight: 600;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .nav-link.active i {
            color: #1e4a2c;
        }

        .nav-link.logout {
            margin-top: 20px;
            color: #ffb3b3;
        }

        .nav-link.logout:hover {
            background-color: rgba(255, 0, 0, 0.2);
            color: #fff;
        }

        /* Page Content Styles */
        #page-content-wrapper {
            width: 100%;
            margin-left: 280px;
        }

        /* Navbar Styles */
        .navbar {
            background-color: #fff;
            padding: 15px 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .search-box {
            position: relative;
            width: 400px;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
            font-size: 1.1rem;
        }

        .search-box input {
            width: 100%;
            padding: 12px 20px 12px 45px;
            border: 1px solid #e9ecef;
            border-radius: 50px;
            background-color: #f8f9fa;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .search-box input:focus {
            outline: none;
            border-color: #2b5e3b;
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(43, 94, 59, 0.1);
        }

        .search-box input::placeholder {
            color: #adb5bd;
            font-style: italic;
        }

        .expert-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .expert-details {
            text-align: right;
        }

        .expert-name {
            font-weight: 600;
            color: #2b5e3b;
            margin-bottom: 4px;
            font-size: 1rem;
        }

        .expert-title {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .expert-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #2b5e3b, #1e4a2c);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffd966;
            font-size: 1.5rem;
            border: 2px solid #ffd966;
        }

        .expert-avatar i {
            font-size: 1.3rem;
        }

        /* Main Content Area */
        .content-wrapper {
            padding: 25px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            #sidebar-wrapper {
                margin-left: -280px;
            }

            #sidebar-wrapper.show {
                margin-left: 0;
            }

            #page-content-wrapper {
                margin-left: 0;
            }

            .search-box {
                width: 250px;
            }
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            @include('master.sidebare')
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <!-- Navbar -->
            @include('master.navbar')

            <!-- Main Content -->
            <div class="content-wrapper">
                @yield('content')

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>~