@extends('master.header')

@section('content')
    @push('style')
        @vite(['resources/css/manajemen-user.css', 'resources/js/manajemen-user.js'])
    @endpush

    <div class="container-fluid px-0">
        <!-- Header Section -->
        <div class="page-header">
            <div>
                <h4 class="page-title">Manajemen User</h4>
                <p class="page-subtitle">Kelola semua user admin di sistem AgroGuard</p>
            </div>
            <a href="{{ route('admin.user.create') }}" class="btn-tambah" style="text-decoration:none;">
                <i class="bi bi-plus-lg"></i>
                Tambah User Baru
            </a>
        </div>

        <!-- Alert Messages -->
        <div id="alertContainer"></div>

        <!-- Table Section -->
        <div class="card table-main-card">
            <div class="card-body p-0">
                <!-- User Count & Actions Header -->
                <div class="d-flex justify-content-between align-items-center p-4 pb-0">
                    <span class="user-count">
                        <i class="bi bi-people-fill me-1"></i> Total User: {{ count($users) }}
                    </span>
                </div>

                <div class="table-responsive p-4">
                    @if(count($users) > 0)
                        <table class="table table-hover align-middle mb-0" id="userTable">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%;">No</th>
                                    <th class="text-start" style="width: 45%;">Email</th>
                                    <th class="text-center" style="width: 25%;">Status</th>
                                    <th class="text-center" style="width: 25%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody" data-delete-route="{{ route('admin.user.delete') }}"
                                data-get-route="{{ route('admin.user.get') }}">
                                @foreach($users as $user)
                                    <tr id="user-{{ $user->_id }}">
                                        <td class="text-muted fw-medium">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="user-avatar">
                                                    <i class="bi bi-person-fill"></i>
                                                </div>
                                                <div>
                                                    <div class="email-text">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="status-badge status-active">Aktif</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-aksi btn-aksi-hapus"
                                                    onclick="confirmDelete('{{ $user->_id }}', '{{ $user->email }}')">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state py-5">
                            <div class="empty-state-icon">
                                <i class="bi bi-people" style="font-size: 3rem; color: #cbd5e1;"></i>
                            </div>
                            <p class="text-muted mt-3">Belum ada user terdaftar</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">Hapus User?</div>
            <div class="modal-text">
                Apakah Anda yakin ingin menghapus user <strong id="deleteUserEmail"></strong>? Tindakan ini tidak dapat
                dibatalkan.
            </div>
            <div class="modal-buttons">
                <button class="btn-modal-cancel" onclick="closeDeleteModal()">Batal</button>
                <button class="btn-modal-delete" id="confirmDeleteBtn" onclick="deleteUser()">
                    <span id="deleteBtnText">Hapus Sekarang</span>
                    <span id="deleteSpinner" class="loading-spinner" style="display: none;"></span>
                </button>
            </div>
        </div>
    </div>

@endsection