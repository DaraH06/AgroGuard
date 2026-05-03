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
    <style>
        /* Anda bisa copy-paste CSS dari login.blade.php Anda ke sini agar tampilannya sama persis */
        body {
            margin: 0;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
            overflow: hidden;
        }

        .container-login {
            display: flex;
            height: 100vh;
        }

        .left {
            width: 45%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: white;
        }

        .login-box {
            width: 100%;
            max-width: 580px;
            padding: 0 40px;
            display: flex;
            flex-direction: column;
        }

        .login-header {
            font-size: 32px;
            font-weight: 700;
            color: #193f25;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-control-custom {
            width: 100%;
            padding: 18px 25px;
            border-radius: 14px;
            border: 1.5px solid #e0e0e0;
            background-color: #e4f5eb;
            font-size: 19px;
            transition: 0.3s;
            margin-bottom: 25px;
        }

        .btn-login {
            background: #2b5e3b;
            color: white;
            border-radius: 14px;
            padding: 18px;
            font-weight: 700;
            font-size: 22px;
            border: none;
            width: 100%;
            transition: 0.3s;
        }

        .right {
            width: 55%;
            background: radial-gradient(circle at 30% 40%, #1e4a2c 0%, #0d2118 100%);
            color: white;
            display: flex;
            align-items: center;
            padding: 100px;
            position: relative;
        }
    </style>
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