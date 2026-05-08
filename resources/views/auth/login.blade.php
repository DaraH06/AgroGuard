<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AgroGuard</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/image/ikon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/login.css', 'resources/js/login.js'])
</head>

<body>

    <div class="container-login">
        <div class="left">
            <div class="login-box">
                <div class="login-header">Login</div>
                @if ($errors->any())
                <div class="alert alert-danger" style="font-size: 15px; border-radius: 10px; margin-bottom: 20px;">
                    {{ $errors->first() }}
                </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf 
                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <div class="input-group-custom">
                            <i class="bi bi-envelope left-icon"></i>
                            <input type="email" name="email" id="email" class="form-control-custom"
                                placeholder="contoh@agroguard.id" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <div class="input-group-custom">
                            <i class="bi bi-lock left-icon"></i>
                            <input type="password" name="password" id="password" class="form-control-custom"
                                placeholder="••••••••••••" required>
                            <i class="bi bi-eye toggle-password" onclick="togglePassword()"></i>
                        </div>
                    </div>

                    <div class="login-options">
                        <a href="{{ route('password.request') }}"
                            style="text-decoration:none; color:#2b5e3b; font-weight: 600;">
                            Lupa Password?
                        </a>
                    </div>

                    <button type="submit" class="btn btn-login">Login</button>
                </form>
            </div>
        </div>

        <div class="right">
            <div class="right-content">
                <span class="right-logo">AgroGuard</span>
                <p>
                    Sistem informasi terintegrasi untuk monitoring, deteksi dini, dan pelaporan penyakit tanaman secara
                    efektif. Kami membantu petani dan ahli agronomi mengambil keputusan cepat berbasis data untuk hasil
                    panen yang lebih baik.
                </p>
            </div>
        </div>
    </div>

</body>

</html>