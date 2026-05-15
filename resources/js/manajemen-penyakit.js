/**
 * Manajemen Penyakit - AgroGuard
 * Dynamic form fields & modal interactions
 */

function getCsrfToken() {
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    if (!csrfTokenMeta) {
        console.error('Meta tag CSRF-TOKEN tidak ditemukan!');
        return null;
    }
    return csrfTokenMeta.getAttribute('content');
}

// Dynamic array inputs (add/remove) for pencegahan and rekomendasi_penanganan
function addItem(listId, nameAttr, value = '') {
    const list = document.getElementById(listId);
    if (!list) return;
    const wrapper = document.createElement('div');
    wrapper.className = 'dynamic-item';

    const ta = document.createElement('textarea');
    ta.name = nameAttr;
    ta.className = 'form-control';
    ta.rows = 3;
    ta.placeholder = '';
    ta.value = value;

    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'btn btn-remove-item';
    btn.title = 'Hapus';
    btn.innerHTML = '&times;';

    wrapper.appendChild(ta);
    wrapper.appendChild(btn);
    list.appendChild(wrapper);
}

// Wire add/remove buttons via event delegation
document.addEventListener('click', (e) => {
    if (e.target && e.target.id === 'deskripsi-add') {
        addItem('deskripsi-list', 'deskripsi[]', '');
    }
    if (e.target && e.target.id === 'pencegahan-add') {
        addItem('pencegahan-list', 'pencegahan[]', '');
    }
    if (e.target && e.target.id === 'penanganan-add') {
        addItem('penanganan-list', 'rekomendasi_penanganan[]', '');
    }
    if (e.target && e.target.classList && e.target.classList.contains('btn-remove-item')) {
        const wrap = e.target.closest('.dynamic-item');
        if (wrap) wrap.remove();
    }
});

// Helper to populate dynamic lists from JSON or plain text
function populateList(data, listId, nameAttr) {
    if (!data) {
        addItem(listId, nameAttr, '');
        return;
    }
    let arr = null;
    try {
        arr = JSON.parse(data);
    } catch (e) {
        // not JSON, treat as single string
    }
    if (Array.isArray(arr)) {
        if (arr.length === 0) addItem(listId, nameAttr, '');
        arr.forEach(v => addItem(listId, nameAttr, v || ''));
    } else {
        addItem(listId, nameAttr, data || '');
    }
}

// Modal lifecycle: populate lists for edit or clear for add
const modalPenyakit = document.getElementById('modalPenyakit');
if (modalPenyakit) {
    modalPenyakit.addEventListener('shown.bs.modal', function (event) {
        const trigger = event.relatedTarget;

        // clear existing
        document.getElementById('deskripsi-list').innerHTML = '';
        document.getElementById('penanganan-list').innerHTML = '';
        document.getElementById('pencegahan-list').innerHTML = '';

        if (trigger && trigger.dataset) {
            populateList(trigger.dataset.deskripsi, 'deskripsi-list', 'deskripsi[]');
            populateList(trigger.dataset.pencegahan, 'pencegahan-list', 'pencegahan[]');
            populateList(trigger.dataset.penanganan, 'penanganan-list', 'rekomendasi_penanganan[]');
        } else {
            // opening via Add button - start with one empty item each
            addItem('deskripsi-list', 'deskripsi[]', '');
            addItem('pencegahan-list', 'pencegahan[]', '');
            addItem('penanganan-list', 'rekomendasi_penanganan[]', '');
        }
    });

    modalPenyakit.addEventListener('hidden.bs.modal', function () {
        document.getElementById('deskripsi-list').innerHTML = '';
        document.getElementById('pencegahan-list').innerHTML = '';
        document.getElementById('penanganan-list').innerHTML = '';
    });
}

// Helper to render data that might be JSON array or plain text
function renderMaybeArray(targetId, data) {
    const el = document.getElementById(targetId);
    if (!el) return;
    let arr = null;
    try {
        arr = JSON.parse(data);
    } catch (e) { }
    if (Array.isArray(arr)) {
        el.innerHTML = '<ul class="mb-0">' + arr.map(i => `<li>${i}</li>`).join('') + '</ul>';
    } else {
        el.textContent = data;
    }
}

// Detail modal logic
document.querySelectorAll('.disease-detail-trigger').forEach((trigger) => {
    trigger.addEventListener('click', () => {
        const nama = trigger.dataset.nama || '';
        const ilmiah = trigger.dataset.ilmiah || '';
        const deskripsi = trigger.dataset.deskripsi || '[]';
        const pencegahan = trigger.dataset.pencegahan || '[]';
        const penanganan = trigger.dataset.penanganan || '[]';
        const riwayat = trigger.dataset.riwayat || '';
        const thumbnail = trigger.dataset.thumbnail || '';

        document.getElementById('detailNamaPenyakit').textContent = `Detail ${nama}`;
        document.getElementById('detailNamaTampil').textContent = nama;
        document.getElementById('detailNamaIlmiah').textContent = ilmiah;
        document.getElementById('detailRiwayat').textContent = riwayat;

        renderMaybeArray('detailDeskripsi', deskripsi);
        renderMaybeArray('detailPencegahan', pencegahan);
        renderMaybeArray('detailPenanganan', penanganan);
        renderMaybeArray('detailRiwayat', riwayat);

        const detailThumbnail = document.getElementById('detailThumbnail');
        detailThumbnail.src = thumbnail;
        detailThumbnail.alt = nama;
    });
});

// ========== AJAX Form Submit dengan Progress Bar ==========
const formTambah = document.getElementById('formTambahPenyakit');
if (formTambah) {
    formTambah.addEventListener('submit', function (e) {
        const datasetInput = formTambah.querySelector('input[name="dataset_zip"]');
        const hasDataset = datasetInput && datasetInput.files.length > 0;

        // Jika tidak ada dataset ZIP, biarkan form submit biasa
        if (!hasDataset) return;

        // Jika ada dataset, gunakan AJAX agar bisa tampilkan progress
        e.preventDefault();

        const progressDiv = document.getElementById('uploadProgress');
        const progressBar = document.getElementById('uploadProgressBar');
        const statusText = document.getElementById('uploadStatusText');
        const btnSimpan = document.getElementById('btnSimpanPenyakit');

        // Tampilkan progress bar
        progressDiv.style.display = 'block';
        btnSimpan.disabled = true;
        btnSimpan.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Memproses...';

        // Animasi progress bar bertahap
        let progress = 0;
        const interval = setInterval(() => {
            if (progress < 30) {
                progress += 2;
                statusText.textContent = 'Mengupload file ZIP...';
            } else if (progress < 60) {
                progress += 0.5;
                statusText.textContent = 'Mengekstrak fitur gambar...';
            } else if (progress < 85) {
                progress += 0.3;
                statusText.textContent = 'Melatih ulang model AI...';
            } else if (progress < 95) {
                progress += 0.1;
                statusText.textContent = 'Hampir selesai...';
            }
            progressBar.style.width = progress + '%';
        }, 200);

        // Kirim form via AJAX
        const formData = new FormData(formTambah);

        fetch(formTambah.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            clearInterval(interval);
            progressBar.style.width = '100%';

            if (data.success) {
                statusText.textContent = '✅ ' + (`${data.message} berjumlah ${data.data} data`);
                progressBar.classList.remove('progress-bar-animated');

                // Reload halaman setelah 1.5 detik
                setTimeout(() => location.reload(), 1500);
            } else {
                statusText.textContent = '❌ Gagal: ' + (data.message || 'Terjadi kesalahan');
                progressBar.classList.replace('bg-success', 'bg-danger');
                btnSimpan.disabled = false;
                btnSimpan.innerHTML = 'Simpan';
            }
        })
        .catch(err => {
            clearInterval(interval);
            statusText.textContent = '❌ Error: ' + err.message;
            progressBar.classList.replace('bg-success', 'bg-danger');
            progressBar.style.width = '100%';
            btnSimpan.disabled = false;
            btnSimpan.innerHTML = 'Simpan';
        });
    });
}

function hapus(id){
    const konfirmasi = confirm('Apakah Anda yakin mau menghapus data ini? Ini akan menghapus seluruh dataset dengan label terkait dan tidak dapat dibatalkan')
    if(konfirmasi){
        const token = getCsrfToken();
        fetch('/admin/penyakit/delete/'+ id, {
            method: 'DELETE',
            headers:{
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN':token
            }
        })
        .then(res => res.json())
        .then(dat => {
            if(dat.success){
                alert(`${data.message}`);
                setTimeout(() => location.reload());
            }else{
                alert('Terjadi kesalahan saat menghapus data')
            }
        })
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.querySelector('.table-responsive table tbody'); // Pastikan selector ini tepat

    if (tableBody) {
        tableBody.addEventListener('click', function(e) {
            // Cek apakah elemen yang diklik adalah tombol hapus
            // Gunakan class yang paling spesifik
            if (e.target.classList.contains('btn-aksi-hapus')) {
                const button = e.target;
                // Ambil ID dari atribut data-id
                const id = button.getAttribute('data-id');

                if (id) {
                    console.log('Tombol hapus diklik, ID:', id); // Log untuk debug
                    hapus(id); // Panggil fungsi hapus
                    e.preventDefault(); // Mencegah aksi default tombol jika ada
                } else {
                    console.error('Tombol hapus tidak memiliki atribut data-id');
                }
            }
        });
    }
});