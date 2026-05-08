/**
 * Manajemen Penyakit - AgroGuard
 * Dynamic form fields & modal interactions
 */

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
        document.getElementById('pencegahan-list').innerHTML = '';
        document.getElementById('penanganan-list').innerHTML = '';

        if (trigger && trigger.dataset) {
            populateList(trigger.dataset.pencegahan, 'pencegahan-list', 'pencegahan[]');
            populateList(trigger.dataset.penanganan, 'penanganan-list', 'rekomendasi_penanganan[]');
        } else {
            // opening via Add button - start with one empty item each
            addItem('pencegahan-list', 'pencegahan[]', '');
            addItem('penanganan-list', 'rekomendasi_penanganan[]', '');
        }
    });

    modalPenyakit.addEventListener('hidden.bs.modal', function () {
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
        const thumbnail = trigger.dataset.thumbnail || '';

        document.getElementById('detailNamaPenyakit').textContent = `Detail ${nama}`;
        document.getElementById('detailNamaTampil').textContent = nama;
        document.getElementById('detailNamaIlmiah').textContent = ilmiah;

        renderMaybeArray('detailDeskripsi', deskripsi);
        renderMaybeArray('detailPencegahan', pencegahan);
        renderMaybeArray('detailPenanganan', penanganan);

        const detailThumbnail = document.getElementById('detailThumbnail');
        detailThumbnail.src = thumbnail;
        detailThumbnail.alt = nama;
    });
});
