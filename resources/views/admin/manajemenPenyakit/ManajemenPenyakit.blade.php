@extends('master.header')

@section('content')
    <div class="container-fluid px-0">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2b5e3b; font-size: 1.6rem;">Manajemen Penyakit</h4>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">Kelola katalog hama dan penyakit tanaman untuk
                    referensi sistem AI.</p>
            </div>
            <button class="btn btn-success d-flex align-items-center gap-2 px-4 py-2 fw-semibold rounded-3"
                data-bs-toggle="modal" data-bs-target="#modalPenyakit"
                style="background-color: #2ecc71; border-color: #2ecc71; font-size: 0.9rem;">
                <i class="bi bi-plus-lg"></i>
                Tambah Penyakit Baru
            </button>
        </div>

        {{-- Search & Filter Bar --}}
        <div class="card border-0 shadow-sm mb-3 rounded-4">
            <div class="card-body py-3 px-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="input-group flex-grow-1" style="max-width: 320px;">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari hama atau inang..."
                            style="box-shadow: none;">
                    </div>
                    <div class="ms-auto d-flex gap-2">
                        <button class="btn btn-outline-secondary d-flex align-items-center gap-2 rounded-3"
                            style="font-size: 0.875rem;">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        <button class="btn btn-outline-secondary d-flex align-items-center gap-2 rounded-3"
                            style="font-size: 0.875rem;">
                            <i class="bi bi-sort-down"></i> Urutkan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Table Card --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 text-center"
                        style="border-collapse: separate; border-spacing: 0;">
                        <thead>
                            <tr style="border-bottom: 1px solid #f0f0f0;">
                                <th class="px-4 py-3 text-uppercase text-muted fw-semibold"
                                    style="font-size: 0.72rem; letter-spacing: 0.07em; width: 100px;">Thumbnail</th>
                                <th class="px-3 py-3 text-uppercase text-muted fw-semibold"
                                    style="font-size: 0.72rem; letter-spacing: 0.07em;">Nama Penyakit</th>
                                <th class="px-3 py-3 text-uppercase text-muted fw-semibold"
                                    style="font-size: 0.72rem; letter-spacing: 0.07em;">Tingkat Bahaya</th>
                                <th class="px-4 py-3 text-uppercase text-muted fw-semibold"
                                    style="font-size: 0.72rem; letter-spacing: 0.07em;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Row 1 --}}
                            <tr style="border-bottom: 1px solid #f5f5f5;">
                                <td class="px-4 py-3">
                                    <img src="{{ asset('images/hawar-daun.jpg') }}" alt="Hawar Daun Bakteri"
                                        class="rounded-3 object-fit-cover"
                                        style="width: 60px; height: 60px; background: #e0e0e0;"
                                        onerror="this.style.background='#d1e7dd'; this.removeAttribute('src');">
                                </td>
                                <td class="px-3 py-3">
                                    <button type="button"
                                        class="btn btn-link p-0 fw-semibold disease-detail-trigger text-decoration-none"
                                        style="color: #1a1a1a; font-size: 0.95rem;" data-bs-toggle="modal"
                                        data-bs-target="#modalDetailPenyakit" data-nama="Hawar Daun Bakteri"
                                        data-ilmiah="Xanthomonas oryzae" data-inang="Padi" data-bahaya="Tinggi"
                                        data-pencegahan="Gunakan benih sehat, lakukan sanitasi lahan, dan rotasi tanaman secara rutin."
                                        data-penanganan="Semprotkan bakterisida tembaga sesuai dosis anjuran dan musnahkan bagian tanaman yang terinfeksi."
                                        data-thumbnail="{{ asset('images/hawar-daun.jpg') }}">
                                        Hawar Daun
                                        Bakteri
                                    </button>
                                </td>
                                <td class="px-3 py-3">
                                    <span class="badge rounded-pill px-3 py-2 fw-semibold"
                                        style="background-color: #fff3cd; color: #b45309; font-size: 0.78rem; letter-spacing: 0.03em;">TINGGI</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-outline-success rounded-3"
                                            style="font-size: 0.8rem;">Detail</button>
                                        <button class="btn btn-sm btn-outline-primary rounded-3"
                                            style="font-size: 0.8rem;">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger rounded-3"
                                            style="font-size: 0.8rem;">Hapus</button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 2 --}}
                            <tr style="border-bottom: 1px solid #f5f5f5;">
                                <td class="px-4 py-3">
                                    <img src="{{ asset('images/ulat-grayak.jpg') }}" alt="Ulat Grayak"
                                        class="rounded-3 object-fit-cover"
                                        style="width: 60px; height: 60px; background: #e0e0e0;"
                                        onerror="this.style.background='#d1e7dd'; this.removeAttribute('src');">
                                </td>
                                <td class="px-3 py-3">
                                    <button type="button"
                                        class="btn btn-link p-0 fw-semibold disease-detail-trigger text-decoration-none"
                                        style="color: #1a1a1a; font-size: 0.95rem;" data-bs-toggle="modal"
                                        data-bs-target="#modalDetailPenyakit" data-nama="Ulat Grayak"
                                        data-ilmiah="Spodoptera litura" data-inang="Jagung, Kedelai" data-bahaya="Sedang"
                                        data-pencegahan="Lakukan monitoring rutin, bersihkan gulma, dan pasang perangkap hama."
                                        data-penanganan="Gunakan insektisida sesuai ambang kendali dan ikuti rekomendasi teknis."
                                        data-thumbnail="{{ asset('images/ulat-grayak.jpg') }}">
                                        Ulat Grayak
                                    </button>
                                </td>
                                <td class="px-3 py-3">
                                    <span class="badge rounded-pill px-3 py-2 fw-semibold"
                                        style="background-color: #e8f5e9; color: #388e3c; font-size: 0.78rem; letter-spacing: 0.03em;">SEDANG</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-outline-success rounded-3"
                                            style="font-size: 0.8rem;">Detail</button>
                                        <button class="btn btn-sm btn-outline-primary rounded-3"
                                            style="font-size: 0.8rem;">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger rounded-3"
                                            style="font-size: 0.8rem;">Hapus</button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 3 --}}
                            <tr style="border-bottom: 1px solid #f5f5f5;">
                                <td class="px-4 py-3">
                                    <img src="{{ asset('images/wereng-cokelat.jpg') }}" alt="Wereng Cokelat"
                                        class="rounded-3 object-fit-cover"
                                        style="width: 60px; height: 60px; background: #e0e0e0;"
                                        onerror="this.style.background='#d1e7dd'; this.removeAttribute('src');">
                                </td>
                                <td class="px-3 py-3">
                                    <button type="button"
                                        class="btn btn-link p-0 fw-semibold disease-detail-trigger text-decoration-none"
                                        style="color: #1a1a1a; font-size: 0.95rem;" data-bs-toggle="modal"
                                        data-bs-target="#modalDetailPenyakit" data-nama="Wereng Cokelat"
                                        data-ilmiah="Nilaparvata lugens" data-inang="Padi" data-bahaya="Kritis"
                                        data-pencegahan="Jaga kebersihan lahan, hindari pemupukan nitrogen berlebih, dan gunakan varietas tahan."
                                        data-penanganan="Aplikasikan insektisida selektif secara tepat dan lakukan pengendalian terpadu."
                                        data-thumbnail="{{ asset('images/wereng-cokelat.jpg') }}">
                                        Wereng
                                        Cokelat
                                    </button>
                                </td>
                                <td class="px-3 py-3">
                                    <span class="badge rounded-pill px-3 py-2 fw-semibold"
                                        style="background-color: #fde8e8; color: #c0392b; font-size: 0.78rem; letter-spacing: 0.03em;">KRITIS</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-outline-success rounded-3"
                                            style="font-size: 0.8rem;">Detail</button>
                                        <button class="btn btn-sm btn-outline-primary rounded-3"
                                            style="font-size: 0.8rem;">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger rounded-3"
                                            style="font-size: 0.8rem;">Hapus</button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 4 --}}
                            <tr style="border-bottom: 1px solid #f5f5f5;">
                                <td class="px-4 py-3">
                                    <img src="{{ asset('images/antraknosa.jpg') }}" alt="Antraknosa"
                                        class="rounded-3 object-fit-cover"
                                        style="width: 60px; height: 60px; background: #e0e0e0;"
                                        onerror="this.style.background='#d1e7dd'; this.removeAttribute('src');">
                                </td>
                                <td class="px-3 py-3">
                                    <button type="button"
                                        class="btn btn-link p-0 fw-semibold disease-detail-trigger text-decoration-none"
                                        style="color: #1a1a1a; font-size: 0.95rem;" data-bs-toggle="modal"
                                        data-bs-target="#modalDetailPenyakit" data-nama="Antraknosa"
                                        data-ilmiah="Colletotrichum spp." data-inang="Cabai, Tomat" data-bahaya="Sedang"
                                        data-pencegahan="Pangkas bagian tanaman yang sakit, jaga sirkulasi udara, dan hindari kelembapan berlebih."
                                        data-penanganan="Gunakan fungisida yang sesuai dan lakukan sanitasi kebun secara rutin."
                                        data-thumbnail="{{ asset('images/antraknosa.jpg') }}">
                                        Antraknosa
                                    </button>
                                </td>
                                <td class="px-3 py-3">
                                    <span class="badge rounded-pill px-3 py-2 fw-semibold"
                                        style="background-color: #e8f5e9; color: #388e3c; font-size: 0.78rem; letter-spacing: 0.03em;">SEDANG</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-outline-success rounded-3"
                                            style="font-size: 0.8rem;">Detail</button>
                                        <button class="btn btn-sm btn-outline-primary rounded-3"
                                            style="font-size: 0.8rem;">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger rounded-3"
                                            style="font-size: 0.8rem;">Hapus</button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 5 --}}
                            <tr>
                                <td class="px-4 py-3">
                                    <img src="{{ asset('images/bulai-jagung.jpg') }}" alt="Bulai Jagung"
                                        class="rounded-3 object-fit-cover"
                                        style="width: 60px; height: 60px; background: #e0e0e0;"
                                        onerror="this.style.background='#d1e7dd'; this.removeAttribute('src');">
                                </td>
                                <td class="px-3 py-3">
                                    <button type="button"
                                        class="btn btn-link p-0 fw-semibold disease-detail-trigger text-decoration-none"
                                        style="color: #1a1a1a; font-size: 0.95rem;" data-bs-toggle="modal"
                                        data-bs-target="#modalDetailPenyakit" data-nama="Bulai Jagung"
                                        data-ilmiah="Peronosclerospora maydis" data-inang="Jagung" data-bahaya="Tinggi"
                                        data-pencegahan="Gunakan benih sehat, tanam varietas tahan, dan hindari kondisi lembap berlebih."
                                        data-penanganan="Musnahkan tanaman terinfeksi dan lakukan pengendalian sesuai rekomendasi."
                                        data-thumbnail="{{ asset('images/bulai-jagung.jpg') }}">
                                        Bulai
                                        Jagung
                                    </button>
                                </td>
                                <td class="px-3 py-3">
                                    <span class="badge rounded-pill px-3 py-2 fw-semibold"
                                        style="background-color: #fff3cd; color: #b45309; font-size: 0.78rem; letter-spacing: 0.03em;">TINGGI</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-outline-success rounded-3"
                                            style="font-size: 0.8rem;">Detail</button>
                                        <button class="btn btn-sm btn-outline-primary rounded-3"
                                            style="font-size: 0.8rem;">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger rounded-3"
                                            style="font-size: 0.8rem;">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Footer --}}
                <div class="d-flex justify-content-between align-items-center px-4 py-3"
                    style="border-top: 1px solid #f0f0f0;">
                    <small class="text-muted">
                        Menampilkan <strong>5</strong> dari <strong>5</strong> data
                    </small>
                    <nav>
                        <ul class="pagination pagination-sm mb-0 gap-1">
                            <li class="page-item disabled">
                                <button class="page-link rounded-3 border-0 text-muted" style="font-size: 0.875rem;">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                            </li>
                            <li class="page-item active">
                                <button class="page-link rounded-3 border-0 fw-semibold"
                                    style="background-color: #2ecc71; color: #fff; font-size: 0.875rem;">1</button>
                            </li>
                            <li class="page-item">
                                <button class="page-link rounded-3 border-0 text-muted"
                                    style="font-size: 0.875rem;">2</button>
                            </li>
                            <li class="page-item">
                                <button class="page-link rounded-3 border-0 text-muted" style="font-size: 0.875rem;">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

    </div>

    {{-- Modal: Tambah/Edit Penyakit --}}
    <div class="modal fade" id="modalPenyakit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form action="{{ route('admin.penyakit.store') }}" method="post">
                    @csrf
                    <div class="modal-header border-0 pb-0 px-4 pt-4">
                        <h5 class="modal-title fw-bold">Tambah Penyakit Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-4 pt-3 pb-2">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size: 0.875rem;">Nama Penyakit</label>
                                <input name="nama_penyakit" type="text" class="form-control rounded-3"
                                    placeholder="Contoh: Hawar Daun Bakteri">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size: 0.875rem;">Nama Ilmiah</label>
                                <input name="nama_ilmiah" type="text" class="form-control rounded-3"
                                    placeholder="Contoh: Xanthomonas oryzae">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold" style="font-size: 0.875rem;">Pencegahan</label>
                                <textarea name="pencegahan" id="tinymce-pencegahan" class="form-control rounded-3" rows="2"
                                    placeholder="Pencegahan dapat dilakukan dengan"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold" style="font-size: 0.875rem;">Rekomendasi
                                    Penanganan</label>
                                <textarea name="rekomendasi_penanganan" id="tinymce-penanganan"
                                    class="form-control rounded-3" rows="2"
                                    placeholder="Contoh: Fungisida tembaga, sanitasi lahan, varietas tahan"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold" style="font-size: 0.875rem;">Thumbnail
                                    Penyakit</label>
                                <input type="file" class="form-control rounded-3" accept="image/*">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold" style="font-size: 0.875rem;">Data set
                                </label>
                                <small class="text-muted d-block mb-2">
                                    Format file: zip/csv yang berisi folder data training dan folder dataset
                                </small>
                                <input type="file" class="form-control rounded-3" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4 pt-2">
                        <button type="button" class="btn btn-outline-secondary rounded-3 px-4"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success rounded-3 px-4 fw-semibold"
                            style="background-color: #2ecc71; border-color: #2ecc71;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDetailPenyakit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <div>
                        <h5 class="modal-title fw-bold mb-1" id="detailNamaPenyakit">Detail Penyakit</h5>
                        <small class="text-muted">Data lengkap dari item yang dipilih</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 pt-3 pb-4">
                    <div class="row g-4 align-items-start">
                        <div class="col-md-4 text-center">
                            <img id="detailThumbnail" src="" alt="Thumbnail Penyakit"
                                class="img-fluid rounded-4 border object-fit-cover"
                                style="width: 100%; max-width: 220px; height: 220px; background: #f1f5f9;">
                        </div>
                        <div class="col-md-8">
                            <div class="d-grid gap-3">
                                <div>
                                    <small class="text-muted d-block">Nama Penyakit</small>
                                    <div class="fw-semibold" id="detailNamaTampil"></div>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Nama Ilmiah</small>
                                    <div class="fst-italic" id="detailNamaIlmiah"></div>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Tanaman Inang</small>
                                    <div id="detailInang"></div>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Tingkat Bahaya</small>
                                    <span class="badge rounded-pill px-3 py-2 fw-semibold" id="detailBahaya"></span>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Pencegahan</small>
                                    <div id="detailPencegahan"></div>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Rekomendasi Penanganan</small>
                                    <div id="detailPenanganan"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    {{-- Fix TinyMCE dialogs appearing behind Bootstrap modal --}}
    <style>
        .tox-tinymce-aux {
            z-index: 1060 !important;
        }
    </style>
@endpush

@push('scripts')
    {{-- TinyMCE Local --}}
    <script src="{{ asset('assets/tinymce/tinymce/js/tinymce/tinymce.min.js') }}"></script>

    <script>
        // ── TinyMCE config for modal ──
        const tinymceConfig = {
            license_key: 'gpl',
            menubar: false,
            branding: false,
            promotion: false,
            statusbar: false,
            height: 200,
            plugins: 'advlist autolink lists link image code help',
            toolbar: 'bold italic underline | bullist numlist | link | removeformat',
            content_style: `
                                        body {
                                            font-family: 'Segoe UI', Roboto, sans-serif;
                                            font-size: 14px;
                                            color: #333;
                                            padding: 4px 8px;
                                        }
                                        `,
            setup: function (editor) {
                editor.on('change keyup', function () {
                    editor.save(); // sync content back to the textarea
                });
            }
        };

        // Initialize TinyMCE when modal opens, destroy when it closes
        const modalPenyakit = document.getElementById('modalPenyakit');

        modalPenyakit.addEventListener('shown.bs.modal', function () {
            // Only init if not already initialized
            if (!tinymce.get('tinymce-pencegahan')) {
                tinymce.init({ ...tinymceConfig, selector: '#tinymce-pencegahan' });
            }
            if (!tinymce.get('tinymce-penanganan')) {
                tinymce.init({ ...tinymceConfig, selector: '#tinymce-penanganan' });
            }
        });

        modalPenyakit.addEventListener('hidden.bs.modal', function () {
            // Destroy editors to prevent stale instances
            if (tinymce.get('tinymce-pencegahan')) {
                tinymce.get('tinymce-pencegahan').destroy();
            }
            if (tinymce.get('tinymce-penanganan')) {
                tinymce.get('tinymce-penanganan').destroy();
            }
        });

        // ── Detail modal logic ──
        document.querySelectorAll('.disease-detail-trigger').forEach((trigger) => {
            trigger.addEventListener('click', () => {
                const nama = trigger.dataset.nama || '';
                const ilmiah = trigger.dataset.ilmiah || '';
                const inang = trigger.dataset.inang || '';
                const bahaya = trigger.dataset.bahaya || '';
                const pencegahan = trigger.dataset.pencegahan || '';
                const penanganan = trigger.dataset.penanganan || '';
                const thumbnail = trigger.dataset.thumbnail || '';

                document.getElementById('detailNamaPenyakit').textContent = `Detail ${nama}`;
                document.getElementById('detailNamaTampil').textContent = nama;
                document.getElementById('detailNamaIlmiah').textContent = ilmiah;
                document.getElementById('detailInang').textContent = inang;
                document.getElementById('detailPencegahan').textContent = pencegahan;
                document.getElementById('detailPenanganan').textContent = penanganan;

                const detailThumbnail = document.getElementById('detailThumbnail');
                detailThumbnail.src = thumbnail;
                detailThumbnail.alt = nama;

                const detailBahaya = document.getElementById('detailBahaya');
                detailBahaya.textContent = bahaya.toUpperCase();

                if (bahaya.toLowerCase() === 'kritis') {
                    detailBahaya.style.backgroundColor = '#fde8e8';
                    detailBahaya.style.color = '#c0392b';
                } else if (bahaya.toLowerCase() === 'tinggi') {
                    detailBahaya.style.backgroundColor = '#fff3cd';
                    detailBahaya.style.color = '#b45309';
                } else {
                    detailBahaya.style.backgroundColor = '#e8f5e9';
                    detailBahaya.style.color = '#388e3c';
                }
            });
        });
    </script>
@endpush