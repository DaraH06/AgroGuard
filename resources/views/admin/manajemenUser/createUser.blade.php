@extends('master.header')

@section('content')
<style>
    .create-user-container {
        padding: 30px;
        background-color: #f8fafc;
        min-height: calc(100vh - 80px);
    }

    .create-user-card {
        background-color: white;
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        margin: 0 auto;
    }

    .form-header {
        margin-bottom: 30px;
        text-align: center;
    }

    .form-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 10px 0;
    }

    .form-header p {
        color: #64748b;
        font-size: 14px;
        margin: 0;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-group input {
        width: 100%;
        padding: 12px 15px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
        box-sizing: border-box;
        font-family: inherit;
    }

    .form-group input:focus {
        outline: none;
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
    }

    .form-group input::placeholder {
        color: #cbd5e1;
    }

    .form-group.error input {
        border-color: #ef4444;
    }

    .form-group.error input:focus {
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .error-message {
        color: #ef4444;
        font-size: 12px;
        margin-top: 6px;
        display: none;
    }

    .form-group.error .error-message {
        display: block;
    }

    .password-requirements {
        background-color: #f0fdf4;
        border: 1px solid #dcfce7;
        border-radius: 8px;
        padding: 12px;
        margin-top: 8px;
        font-size: 12px;
        color: #166534;
    }

    .password-requirements li {
        margin: 4px 0;
        list-style-position: inside;
    }

    .password-requirements li.met {
        color: #16a34a;
        font-weight: 600;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 30px;
    }

    .btn-submit {
        flex: 1;
        background-color: #16a34a;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-submit:hover:not(:disabled) {
        background-color: #15803d;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
    }

    .btn-submit:disabled {
        background-color: #9ca3af;
        cursor: not-allowed;
    }

    .btn-cancel {
        flex: 1;
        background-color: #e2e8f0;
        color: #475569;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-cancel:hover {
        background-color: #cbd5e1;
        transform: translateY(-2px);
    }

    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .alert-error {
        background-color: #fee2e2;
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }

    .alert-close {
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        font-size: 18px;
        padding: 0;
    }

    .loading-spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid #ffffff;
        border-top: 2px solid transparent;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    @media (max-width: 768px) {
        .create-user-container {
            padding: 20px;
        }

        .create-user-card {
            padding: 25px;
        }

        .form-header h1 {
            font-size: 24px;
        }

        .form-actions {
            flex-direction: column;
        }
    }
</style>

<div class="create-user-container">
    <div class="create-user-card">
        <div class="form-header">
            <h1>Buat User Baru</h1>
            <p>Tambahkan akun admin baru ke sistem AgroGuard</p>
        </div>

        <div id="alertContainer"></div>

        <form id="createUserForm">
            @csrf
            
            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="admin@agroguard.com" 
                    required
                    autocomplete="email"
                >
                <div class="error-message">Email tidak valid atau sudah terdaftar</div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Minimal 8 karakter" 
                    required
                    autocomplete="new-password"
                >
                <div class="error-message">Password minimal 8 karakter</div>
                <ul class="password-requirements">
                    <li id="req-length">Minimal 8 karakter</li>
                    <li id="req-uppercase">Mengandung huruf besar (A-Z)</li>
                    <li id="req-lowercase">Mengandung huruf kecil (a-z)</li>
                    <li id="req-number">Mengandung angka (0-9)</li>
                </ul>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    placeholder="Ulangi password" 
                    required
                    autocomplete="new-password"
                >
                <div class="error-message">Password tidak cocok</div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.user.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">
                    <span id="submitText">Buat User</span>
                    <span id="submitSpinner" class="loading-spinner" style="display: none;"></span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const form = document.getElementById('createUserForm');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const emailInput = document.getElementById('email');
    const submitBtn = form.querySelector('button[type="submit"]');

    // Password requirements validation
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        
        const hasLength = password.length >= 8;
        const hasUppercase = /[A-Z]/.test(password);
        const hasLowercase = /[a-z]/.test(password);
        const hasNumber = /[0-9]/.test(password);

        updateRequirement('req-length', hasLength);
        updateRequirement('req-uppercase', hasUppercase);
        updateRequirement('req-lowercase', hasLowercase);
        updateRequirement('req-number', hasNumber);

        validatePasswordMatch();
    });

    passwordConfirmInput.addEventListener('input', function() {
        validatePasswordMatch();
    });

    function updateRequirement(id, isMet) {
        const element = document.getElementById(id);
        if (isMet) {
            element.classList.add('met');
        } else {
            element.classList.remove('met');
        }
    }

    function validatePasswordMatch() {
        const password = passwordInput.value;
        const passwordConfirm = passwordConfirmInput.value;
        
        if (passwordConfirm && password !== passwordConfirm) {
            passwordConfirmInput.parentElement.classList.add('error');
        } else {
            passwordConfirmInput.parentElement.classList.remove('error');
        }
    }

    function isPasswordValid() {
        const password = passwordInput.value;
        return password.length >= 8 && 
               /[A-Z]/.test(password) && 
               /[a-z]/.test(password) && 
               /[0-9]/.test(password);
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Validation
        const email = emailInput.value.trim();
        const password = passwordInput.value;
        const passwordConfirm = passwordConfirmInput.value;

        if (!email) {
            showAlert('Email harus diisi', 'error');
            emailInput.parentElement.classList.add('error');
            return;
        }

        if (!isPasswordValid()) {
            showAlert('Password harus memenuhi semua syarat', 'error');
            passwordInput.parentElement.classList.add('error');
            return;
        }

        if (password !== passwordConfirm) {
            showAlert('Password tidak cocok', 'error');
            passwordConfirmInput.parentElement.classList.add('error');
            return;
        }

        // Disable submit button and show loading
        submitBtn.disabled = true;
        document.getElementById('submitText').style.display = 'none';
        document.getElementById('submitSpinner').style.display = 'inline-block';

        try {
            const response = await fetch('{{ route('admin.user.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    email: email,
                    password: password,
                    password_confirmation: passwordConfirm
                })
            });

            const data = await response.json();

            if (data.success) {
                showAlert('User berhasil dibuat! Redirecting...', 'success');
                setTimeout(() => {
                    window.location.href = '{{ route('admin.user.index') }}';
                }, 1500);
            } else {
                showAlert(data.message || 'Gagal membuat user', 'error');
                submitBtn.disabled = false;
                document.getElementById('submitText').style.display = 'inline';
                document.getElementById('submitSpinner').style.display = 'none';
            }
        } catch (error) {
            console.error('Error:', error);
            showAlert('Terjadi kesalahan: ' + error.message, 'error');
            submitBtn.disabled = false;
            document.getElementById('submitText').style.display = 'inline';
            document.getElementById('submitSpinner').style.display = 'none';
        }
    });

    function showAlert(message, type) {
        const alertContainer = document.getElementById('alertContainer');
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type}`;
        alertDiv.innerHTML = `
            <span>${message}</span>
            <button type="button" class="alert-close" onclick="this.parentElement.remove();">&times;</button>
        `;
        alertContainer.appendChild(alertDiv);

        if (type === 'error') {
            setTimeout(() => {
                if (alertDiv.parentElement) {
                    alertDiv.remove();
                }
            }, 5000);
        }
    }

    // Remove error class when typing
    emailInput.addEventListener('input', function() {
        this.parentElement.classList.remove('error');
    });

    passwordInput.addEventListener('input', function() {
        this.parentElement.classList.remove('error');
    });
</script>
@endsection
