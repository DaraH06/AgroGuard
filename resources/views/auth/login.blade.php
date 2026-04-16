<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AgroGuard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            margin: 0;
            height: 100vh;
            font-family: 'Segoe UI', sans-serif;
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
            font-family: 'Segoe UI', sans-serif;
            font-size: 36px; 
            font-weight: 700;
            color: #193f25;
            margin-bottom: 35px;
            text-align: center;
            letter-spacing: -1px;
        }

        .form-group label {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 12px;
            display: block;
            color: #444;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 30px;
        }

        .input-group-custom .left-icon {
            position: absolute;
            top: 50%;
            left: 25px;
            transform: translateY(-50%);
            color: #999;
            font-size: 24px; 
            z-index: 10;
        }

        .form-control-custom {
            width: 100%;
            padding: 18px 25px 18px 70px; 
            border-radius: 14px;
            border: 1.5px solid #e0e0e0;
            background-color: #e4f5eb;
            font-size: 19px; 
            transition: 0.3s;
        }

        .form-control-custom:focus {
            border-color: #2b5e3b;
            box-shadow: 0 0 0 5px rgba(43, 94, 59, 0.1);
            outline: none;
            background-color: #fff;
        }

        .toggle-password {
            position: absolute;
            right: 25px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
            font-size: 24px; 
            z-index: 10;
        }

        .login-options a {
            font-size: 17px; 
            font-weight: 600; 
            color: #2b5e3b; 
            text-decoration: none;
            transition: 0.3s;
        }

        .login-options a:hover {
            color: #1e4a2c;
            text-decoration: underline;
        }

        .login-options {
            display: flex;
            justify-content: flex-end;
            margin-top: -10px;
            margin-bottom: 35px;
            font-size: 15px;
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
            box-shadow: 0 8px 15px rgba(43, 94, 59, 0.1);
        }

        .btn-login:hover {
            background: #1e4a2c;
            transform: translateY(-2px);
            box-shadow: 0 12px 20px rgba(43, 94, 59, 0.2);
        }

        .right {
            width: 55%;
            background: radial-gradient(circle at 30% 40%, #1e4a2c 0%, #0d2118 100%);
            color: white;
            display: flex;
            justify-content: flex-start; 
            align-items: center;
            padding: 80px 60px 80px 100px; 
            position: relative;
            overflow: hidden;
        }

        .right::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 8px; 
            height: 100%;
            background: linear-gradient(to right, #ffffff 50%, #a1a1a1 50%);
            z-index: 5;
        }

        .right-content {
            max-width: 90%; 
            text-align: left; 
            position: relative;
            z-index: 2;
        }

        .right-logo {
            font-size: 64px;
            font-weight: 800;
            margin-bottom: 25px;
            display: block;
            letter-spacing: -1px;
        }

        .right-content p {
            font-size: 20px;
            line-height: 1.7;
            opacity: 0.9;
            text-align: justify;
        }

        @media (max-width: 992px) {
            .container-login { flex-direction: column; overflow-y: auto; }
            .left, .right { width: 100%; height: auto; padding: 60px 20px; }
            .login-box { max-width: 100%; }
        }
    </style>
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
                @csrf <div class="form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope left-icon"></i>
                        <input type="email" name="email" id="email" class="form-control-custom" placeholder="contoh@agroguard.id" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock left-icon"></i>
                        <input type="password" name="password" id="password" class="form-control-custom" placeholder="••••••••••••" required>
                        <i class="bi bi-eye toggle-password" onclick="togglePassword()"></i>
                    </div>
                </div>

                <div class="login-options">
                    <a href="{{ route('password.request') }}" style="text-decoration:none; color:#2b5e3b; font-weight: 600;">
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
                Sistem informasi terintegrasi untuk monitoring, deteksi dini, dan pelaporan penyakit tanaman secara efektif. Kami membantu petani dan ahli agronomi mengambil keputusan cepat berbasis data untuk hasil panen yang lebih baik.
            </p>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById("password");
    const icon = document.querySelector(".toggle-password");
    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace("bi-eye", "bi-eye-slash");
    } else {
        input.type = "password";
        icon.classList.replace("bi-eye-slash", "bi-eye");
    }
}
</script>

</body>
</html>