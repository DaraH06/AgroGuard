@extends('master.header')

@section('content')
<style>
    .user-management-container {
        padding: 30px;
        background-color: #f8fafc;
        min-height: calc(100vh - 80px);
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .header-section h1 {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .btn-add-user {
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
        gap: 8px;
    }

    .btn-add-user:hover {
        background-color: #15803d;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
    }

    .table-container {
        background-color: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
    }

    .table-container table {
        width: 100%;
        border-collapse: collapse;
    }

    .table-container th {
        background-color: #f1f5f9;
        padding: 15px;
        text-align: left;
        font-weight: 600;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-container td {
        padding: 15px;
        border-bottom: 1px solid #e2e8f0;
        color: #475569;
    }

    .table-container tbody tr:hover {
        background-color: #f8fafc;
    }

    .table-container tbody tr:last-child td {
        border-bottom: none;
    }

    .email-column {
        font-weight: 500;
        color: #1e293b;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-delete {
        background-color: #ef4444;
        color: white;
        padding: 8px 15px;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-delete:hover {
        background-color: #dc2626;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }

    .btn-delete:active {
        transform: translateY(0);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 15px;
    }

    .empty-state p {
        font-size: 16px;
        margin: 0;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-active {
        background-color: #dcfce7;
        color: #166534;
    }

    .status-inactive {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .row-number {
        color: #cbd5e1;
        font-weight: 500;
        width: 40px;
    }

    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-content {
        background-color: white;
        border-radius: 12px;
        padding: 30px;
        max-width: 400px;
        box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 15px;
    }

    .modal-text {
        color: #64748b;
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .modal-buttons {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .btn-modal-cancel {
        background-color: #e2e8f0;
        color: #475569;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-modal-cancel:hover {
        background-color: #cbd5e1;
    }

    .btn-modal-delete {
        background-color: #ef4444;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-modal-delete:hover {
        background-color: #dc2626;
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

    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .alert-success {
        background-color: #dcfce7;
        color: #166534;
        border-left: 4px solid #16a34a;
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

    .user-count {
        background-color: #e0f2fe;
        color: #0369a1;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .user-management-container {
            padding: 20px;
        }

        .header-section {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }

        .table-container {
            padding: 15px;
        }

        .table-container th,
        .table-container td {
            padding: 10px;
            font-size: 12px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-delete {
            width: 100%;
        }
    }
</style>

<div class="user-management-container">
    <!-- Header Section -->
    <div class="header-section">
        <div>
            <h1>Manajemen User</h1>
            <p style="color: #64748b; margin: 8px 0 0 0; font-size: 14px;">Kelola semua user admin di sistem AgroGuard</p>
        </div>
        <button class="btn-add-user" onclick="openAddUserModal()">
            <span>+</span>
            Tambah User Baru
        </button>
    </div>

    <!-- User Count -->
    <div style="margin-bottom: 20px;">
        <span class="user-count">Total User: {{ count($users) }}</span>
    </div>

    <!-- Alert Messages -->
    <div id="alertContainer"></div>

    <!-- Table Section -->
    <div class="table-container">
        @if(count($users) > 0)
            <table id="userTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Email</th>
                        <th style="width: 150px;">Status</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    @foreach($users as $user)
                        <tr id="user-{{ $user->_id }}">
                            <td class="row-number">{{ $loop->iteration }}</td>
                            <td class="email-column">{{ $user->email }}</td>
                            <td>
                                <span class="status-badge status-active">Aktif</span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-delete" onclick="confirmDelete('{{ $user->_id }}', '{{ $user->email }}')">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">👥</div>
                <p>Belum ada user terdaftar</p>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">Hapus User?</div>
        <div class="modal-text">
            Apakah Anda yakin ingin menghapus user <strong id="deleteUserEmail"></strong>? Tindakan ini tidak dapat dibatalkan.
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

<script>
    let userToDelete = null;

    function openAddUserModal() {
        window.location.href = '{{ route('admin.user.create') }}';
    }

    function confirmDelete(userId, userEmail) {
        userToDelete = userId;
        document.getElementById('deleteUserEmail').textContent = userEmail;
        document.getElementById('deleteModal').classList.add('show');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('show');
        userToDelete = null;
    }

    function deleteUser() {
        if (!userToDelete) return;

        const confirmBtn = document.getElementById('confirmDeleteBtn');
        const deleteBtnText = document.getElementById('deleteBtnText');
        const deleteSpinner = document.getElementById('deleteSpinner');

        confirmBtn.disabled = true;
        deleteBtnText.style.display = 'none';
        deleteSpinner.style.display = 'inline-block';

        fetch('{{ route('admin.user.delete') }}', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({
                id: userToDelete
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('User berhasil dihapus', 'success');
                const userRow = document.getElementById(`user-${userToDelete}`);
                if (userRow) {
                    userRow.remove();
                }
                closeDeleteModal();
                
                // Update user count
                const tableBody = document.getElementById('userTableBody');
                if (tableBody.children.length === 0) {
                    location.reload();
                }
            } else {
                showAlert(data.message || 'Gagal menghapus user', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Terjadi kesalahan: ' + error.message, 'error');
        })
        .finally(() => {
            confirmBtn.disabled = false;
            deleteBtnText.style.display = 'inline';
            deleteSpinner.style.display = 'none';
        });
    }

    function showAlert(message, type) {
        const alertContainer = document.getElementById('alertContainer');
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type}`;
        alertDiv.innerHTML = `
            <span>${message}</span>
            <button class="alert-close" onclick="this.parentElement.remove();">&times;</button>
        `;
        alertContainer.appendChild(alertDiv);

        setTimeout(() => {
            if (alertDiv.parentElement) {
                alertDiv.remove();
            }
        }, 4000);
    }

    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // Load users on page load
    function loadUsers() {
        fetch('{{ route('admin.user.get') }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Users loaded
                }
            })
            .catch(error => console.error('Error loading users:', error));
    }

    // Load users on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadUsers();
    });
</script>
@endsection
