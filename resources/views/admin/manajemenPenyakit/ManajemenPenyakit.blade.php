@extends('master.header')

@push('style')
    @vite(['resources/css/manajemen-penyakit.css', 'resources/js/manajemen-penyakit.js'])
@endpush

@section('content')
    <div class="container-fluid px-0">

        {{-- Header --}}
        <div class="page-header">
            <div>
                <h4 class="page-title">Manajemen Penyakit</h4>
                <p class="page-subtitle">Kelola katalog hama dan penyakit tanaman untuk referensi sistem AI.</p>
            </div>
            <button class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#modalPenyakit">
                <i class="bi bi-plus-lg"></i>
                Tambah Penyakit Baru
            </button>
        </div>

        {{-- Search & Filter Bar --}}
        <div class="card search-filter-card">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="input-group flex-grow-1" style="max-width: 320px;">
                        <span class="input-group-text border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari penyakit..."
                            style="box-shadow: none;">
                    </div>
                    <div class="ms-auto d-flex gap-2">
                        <button class="btn btn-filter">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        <button class="btn btn-filter">
                            <i class="bi bi-sort-down"></i> Urutkan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Table Card --}}
        <div class="card table-main-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 90px;">Thumbnail</th>
                                <th class="text-start">Nama Penyakit</th>
                                <th class="text-center">Jumlah Dataset</th>
                                <th class="text-center" style="width: 220px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Row 1 --}}
                            @foreach ($daftar_penyakit as $baris)
                                <tr>
                                    <td class="text-center">
                                        <img src="{{ asset("images/{$baris['thumbnail']}") }}" alt="{{ $baris['thumbnail'] }}"
                                            class="disease-thumbnail"
                                            onerror="this.style.background='linear-gradient(135deg, #dcfce7, #bbf7d0)'; this.removeAttribute('src');">
                                    </td>
                                    <td>
                                        <div class="disease-name">{{ $baris['nama_penyakit'] }}</div>
                                        <div class="disease-ilmiah">{{ $baris['nama_ilmiah'] }}</div>
                                    </td>
                                    <td>
                                        <div class="disease-name text-center">{{ $baris['jumlah dataset'] }}</div>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-2">
                                            <button type="button"
                                                class="btn btn-sm btn-outline-success btn-aksi btn-aksi-detail disease-detail-trigger"
                                                data-bs-toggle="modal" data-bs-target="#modalDetailPenyakit"
                                                data-nama="{{ $baris['nama_penyakit'] }}"
                                                data-ilmiah="{{ $baris['nama_ilmiah'] }}"
                                                data-deskripsi='@json($baris['deskripsi'] ?? [])'
                                                data-pencegahan='@json($baris['penanggulangan'] ?? [])'
                                                data-penanganan='@json($baris['penanganan'] ?? [])'
                                                data-thumbnail="{{ asset("images/{$baris['thumbnail']}") }}">Detail</button>
                                            <button class="btn btn-sm btn-outline-primary btn-aksi btn-aksi-edit">Edit</button>
                                            <button class="btn btn-sm btn-outline-danger btn-aksi btn-aksi-hapus">Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Footer --}}
                <div class="pagination-footer">
                    <small class="text-muted">
                        Menampilkan <strong>5</strong> dari <strong>5</strong> data
                    </small>
                    <nav>
                        <ul class="pagination pagination-sm mb-0 gap-1">
                            <li class="page-item disabled">
                                <button class="page-link"><i class="bi bi-chevron-left"></i></button>
                            </li>
                            <li class="page-item active">
                                <button class="page-link">1</button>
                            </li>
                            <li class="page-item">
                                <button class="page-link">2</button>
                            </li>
                            <li class="page-item">
                                <button class="page-link"><i class="bi bi-chevron-right"></i></button>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

    </div>

    {{-- Modal: Tambah/Edit Penyakit --}}
    <div class="modal fade modal-penyakit" id="modalPenyakit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="formTambahPenyakit" action="{{ route('admin.penyakit.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Penyakit Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Penyakit</label>
                                <input name="nama_penyakit" type="text" class="form-control"
                                    placeholder="Contoh: Hawar Daun Bakteri" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Ilmiah</label>
                                <input name="nama_ilmiah" type="text" class="form-control"
                                    placeholder="Contoh: Xanthomonas oryzae">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Deskripsi</label>
                                <div id="deskripsi-container">
                                    <div id="deskripsi-list" class="d-grid gap-2">
                                        <div class="dynamic-item">
                                            <textarea name="deskripsi[]" class="form-control" rows="3"
                                                placeholder="Contoh: Penyakit yang disebabkan oleh bakteri..."></textarea>
                                            <button type="button" class="btn btn-remove-item" title="Hapus">&times;</button>
                                        </div>
                                    </div>
                                    <button type="button" id="deskripsi-add" class="btn btn-add-field">
                                        <i class="bi bi-plus-lg"></i> Tambah Kolom Deskripsi
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Pencegahan</label>
                                <div id="pencegahan-container">
                                    <div id="pencegahan-list" class="d-grid gap-2">
                                        <div class="dynamic-item">
                                            <textarea name="pencegahan[]" class="form-control" rows="3"
                                                placeholder="Contoh: Perbaiki drainase, rotasi tanaman"></textarea>
                                            <button type="button" class="btn btn-remove-item" title="Hapus">&times;</button>
                                        </div>
                                    </div>
                                    <button type="button" id="pencegahan-add" class="btn btn-add-field">
                                        <i class="bi bi-plus-lg"></i> Tambah Kolom Pencegahan
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Rekomendasi Penanganan</label>
                                <div id="penanganan-container">
                                    <div id="penanganan-list" class="d-grid gap-2">
                                        <div class="dynamic-item">
                                            <textarea name="rekomendasi_penanganan[]" class="form-control" rows="3"
                                                placeholder="Contoh: Fungisida tembaga, sanitasi lahan"></textarea>
                                            <button type="button" class="btn btn-remove-item" title="Hapus">&times;</button>
                                        </div>
                                    </div>
                                    <button type="button" id="penanganan-add" class="btn btn-add-field">
                                        <i class="bi bi-plus-lg"></i> Tambah Kolom Penanganan
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Thumbnail Penyakit</label>
                                <input name="thumbnail_file" type="file" class="form-control" accept="image/*">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Dataset Training</label>
                                <small class="text-muted d-block mb-2" style="font-size: 0.8rem;">
                                    Format file: ZIP berisi folder gambar penyakit (.jpg, .png, .jpeg)
                                </small>
                                <input name="dataset_zip" type="file" class="form-control" accept=".zip">
                            </div>
                        </div>

                        {{-- Progress Bar --}}
                        <div id="uploadProgress" class="mt-3" style="display: none;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="spinner-border spinner-border-sm text-success" role="status"></div>
                                <small id="uploadStatusText" class="text-muted">Mengupload dan memproses dataset...</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div id="uploadProgressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                    role="progressbar" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" id="btnSimpanPenyakit" class="btn btn-modal-save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal: Detail Penyakit --}}
    <div class="modal fade modal-detail" id="modalDetailPenyakit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title mb-1" id="detailNamaPenyakit">Detail Penyakit</h5>
                        <small class="text-muted" style="font-size: 0.8rem;">Data lengkap dari item yang dipilih</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4 align-items-start">
                        <div class="col-md-4 text-center">
                            <img id="detailThumbnail" src="" alt="Thumbnail Penyakit" class="detail-thumbnail">
                        </div>
                        <div class="col-md-8">
                            <div class="d-grid gap-3">
                                <div>
                                    <div class="detail-label">Nama Penyakit</div>
                                    <div class="detail-value fw-bold" id="detailNamaTampil"></div>
                                </div>
                                <div>
                                    <div class="detail-label">Nama Ilmiah</div>
                                    <div class="detail-value detail-ilmiah-value" id="detailNamaIlmiah"></div>
                                </div>
                                <div>
                                    <div class="detail-label">Deskripsi</div>
                                    <div class="detail-value" id="detailDeskripsi"></div>
                                </div>
                                <div>
                                    <div class="detail-label">Pencegahan</div>
                                    <div class="detail-value" id="detailPencegahan"></div>
                                </div>
                                <div>
                                    <div class="detail-label">Rekomendasi Penanganan</div>
                                    <div class="detail-value" id="detailPenanganan"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection