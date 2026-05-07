<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - AgroGuard</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/image/ikon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite('resources/css/forgot-password.css')
</head>

<body>

    <div class="container-login">
        <div class="left">
            <div class="login-box">
                <div class="login-header">Reset Password</div>
                <p class="text-center text-muted mb-4">Masukkan email Anda untuk menerima instruksi reset password.</p>

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="email" name="email" class="form-control-custom" placeholder="Masukkan Email Anda"
                            required>
                    </div>
                    <button type="submit" class="btn btn-login">Kirim Link Reset</button>

                    <div class="text-center mt-4">
                        <a href="/login" style="text-decoration:none; color:#2b5e3b; font-weight: 600;"> Kembali ke
                            Login</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="right">
            <div class="right-content">
                <span style="font-size: 64px; font-weight: 800;">AgroGuard</span>
                <p style="font-size: 20px; opacity: 0.9;">Keamanan tanaman Anda adalah prioritas kami. Pastikan email
                    yang Anda masukkan sudah terdaftar di sistem.</p>
            </div>
        </div>
    </div>

</body>

</html>