let userToDelete = null;

// Expose these to window so inline onclick can find them
window.confirmDelete = function(userId, userEmail) {
    userToDelete = userId;
    const emailEl = document.getElementById('deleteUserEmail');
    if (emailEl) emailEl.textContent = userEmail;
    
    const modal = document.getElementById('deleteModal');
    if (modal) modal.classList.add('show');
}

window.closeDeleteModal = function() {
    const modal = document.getElementById('deleteModal');
    if (modal) modal.classList.remove('show');
    userToDelete = null;
}

window.deleteUser = function() {
    if (!userToDelete) return;

    const confirmBtn = document.getElementById('confirmDeleteBtn');
    const deleteBtnText = document.getElementById('deleteBtnText');
    const deleteSpinner = document.getElementById('deleteSpinner');
    const deleteRoute = document.getElementById('userTableBody').dataset.deleteRoute; // Using a data attribute

    if (confirmBtn) confirmBtn.disabled = true;
    if (deleteBtnText) deleteBtnText.style.display = 'none';
    if (deleteSpinner) deleteSpinner.style.display = 'inline-block';

    fetch(deleteRoute, {
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
            
            // Update user count or reload if empty
            const tableBody = document.getElementById('userTableBody');
            if (tableBody && tableBody.children.length === 0) {
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
        if (confirmBtn) confirmBtn.disabled = false;
        if (deleteBtnText) deleteBtnText.style.display = 'inline';
        if (deleteSpinner) deleteSpinner.style.display = 'none';
    });
}

function showAlert(message, type) {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;

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
const deleteModal = document.getElementById('deleteModal');
if (deleteModal) {
    deleteModal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
}

// Load users on page load
function loadUsers() {
    const tableBody = document.getElementById('userTableBody');
    if (!tableBody) return;
    const getRoute = tableBody.dataset.getRoute;
    if (!getRoute) return;

    fetch(getRoute)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Users loaded
            }
        })
        .catch(error => console.error('Error loading users:', error));
}

document.addEventListener('DOMContentLoaded', function() {
    loadUsers();
});
