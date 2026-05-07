@extends('master.header')

@section('content')
@push('style')
    @vite(['resources/css/create-user.css', 'resources/js/create-user.js'])
@endpush

<div class="create-user-container">
    <div class="create-user-card">
        <div class="form-header">
            <h1>Buat User Baru</h1>
            <p>Tambahkan akun admin baru ke sistem AgroGuard</p>
        </div>

        <div id="alertContainer"></div>

        <form id="createUserForm" data-action="{{ route('admin.user.store') }}" data-redirect="{{ route('admin.user.index') }}">
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


@endsection
