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
                <table class="table align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
                    <thead>
                        <tr style="border-bottom: 1px solid #f0f0f0;">
                            <th class="px-4 py-3 text-uppercase text-muted fw-semibold"
                                style="font-size: 0.72rem; letter-spacing: 0.07em; width: 100px;">Thumbnail</th>
                            <th class="px-3 py-3 text-uppercase text-muted fw-semibold"
                                style="font-size: 0.72rem; letter-spacing: 0.07em;">Nama Penyakit</th>
                            <th class="px-3 py-3 text-uppercase text-muted fw-semibold"
                                style="font-size: 0.72rem; letter-spacing: 0.07em;">Nama Ilmiah</th>
                            <th class="px-3 py-3 text-uppercase text-muted fw-semibold"
                                style="font-size: 0.72rem; letter-spacing: 0.07em;">Tanaman Inang</th>
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
                                <span class="fw-semibold" style="color: #1a1a1a; font-size: 0.95rem;">Hawar Daun
                                    Bakteri</span>
                            </td>
                            <td class="px-3 py-3">
                                <span class="fst-italic text-muted" style="font-size: 0.875rem;">Xanthomonas
                                    oryzae</span>
                            </td>
                            <td class="px-3 py-3">
                                <span class="badge bg-light text-dark border me-1 fw-normal px-2 py-1 rounded-2"
                                    style="font-size: 0.78rem;">PADI</span>
                            </td>
                            <td class="px-3 py-3">
                                <span class="badge rounded-pill px-3 py-2 fw-semibold"
                                    style="background-color: #fff3cd; color: #b45309; font-size: 0.78rem; letter-spacing: 0.03em;">TINGGI</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex gap-2">
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
                                <span class="fw-semibold" style="color: #1a1a1a; font-size: 0.95rem;">Ulat Grayak</span>
                            </td>
                            <td class="px-3 py-3">
                                <span class="fst-italic text-muted" style="font-size: 0.875rem;">Spodoptera
                                    litura</span>
                            </td>
                            <td class="px-3 py-3">
                                <span class="badge bg-light text-dark border me-1 fw-normal px-2 py-1 rounded-2"
                                    style="font-size: 0.78rem;">JAGUNG</span>
                                <span class="badge bg-light text-dark border fw-normal px-2 py-1 rounded-2"
                                    style="font-size: 0.78rem;">KEDELAI</span>
                            </td>
                            <td class="px-3 py-3">
                                <span class="badge rounded-pill px-3 py-2 fw-semibold"
                                    style="background-color: #e8f5e9; color: #388e3c; font-size: 0.78rem; letter-spacing: 0.03em;">SEDANG</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex gap-2">
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
                                <span class="fw-semibold" style="color: #1a1a1a; font-size: 0.95rem;">Wereng
                                    Cokelat</span>
                            </td>
                            <td class="px-3 py-3">
                                <span class="fst-italic text-muted" style="font-size: 0.875rem;">Nilaparvata
                                    lugens</span>
                            </td>
                            <td class="px-3 py-3">
                                <span class="badge bg-light text-dark border me-1 fw-normal px-2 py-1 rounded-2"
                                    style="font-size: 0.78rem;">PADI</span>
                            </td>
                            <td class="px-3 py-3">
                                <span class="badge rounded-pill px-3 py-2 fw-semibold"
                                    style="background-color: #fde8e8; color: #c0392b; font-size: 0.78rem; letter-spacing: 0.03em;">KRITIS</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex gap-2">
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
                                <span class="fw-semibold" style="color: #1a1a1a; font-size: 0.95rem;">Antraknosa</span>
                            </td>
                            <td class="px-3 py-3">
                                <span class="fst-italic text-muted" style="font-size: 0.875rem;">Colletotrichum
                                    spp.</span>
                            </td>
                            <td class="px-3 py-3">
                                <span class="badge bg-light text-dark border me-1 fw-normal px-2 py-1 rounded-2"
                                    style="font-size: 0.78rem;">CABAI</span>
                                <span class="badge bg-light text-dark border fw-normal px-2 py-1 rounded-2"
                                    style="font-size: 0.78rem;">TOMAT</span>
                            </td>
                            <td class="px-3 py-3">
                                <span class="badge rounded-pill px-3 py-2 fw-semibold"
                                    style="background-color: #e8f5e9; color: #388e3c; font-size: 0.78rem; letter-spacing: 0.03em;">SEDANG</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex gap-2">
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
                                <span class="fw-semibold" style="color: #1a1a1a; font-size: 0.95rem;">Bulai
                                    Jagung</span>
                            </td>
                            <td class="px-3 py-3">
                                <span class="fst-italic text-muted" style="font-size: 0.875rem;">Peronosclerospora
                                    maydis</span>
                            </td>
                            <td class="px-3 py-3">
                                <span class="badge bg-light text-dark border me-1 fw-normal px-2 py-1 rounded-2"
                                    style="font-size: 0.78rem;">JAGUNG</span>
                            </td>
                            <td class="px-3 py-3">
                                <span class="badge rounded-pill px-3 py-2 fw-semibold"
                                    style="background-color: #fff3cd; color: #b45309; font-size: 0.78rem; letter-spacing: 0.03em;">TINGGI</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex gap-2">
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
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 0.875rem;">Tanaman Inang</label>
                            <select name="inang" class="form-select rounded-3">
                                <option value="">Pilih tanaman...</option>
                                <option>Padi</option>
                                <option>Jagung</option>
                                <option>Kedelai</option>
                                <option>Cabai</option>
                                <option>Tomat</option>
                                <option>Sayuran Daun</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 0.875rem;">Tingkat Bahaya</label>
                            <select class="form-select rounded-3">
                                <option>Rendah</option>
                                <option>Sedang</option>
                                <option>Tinggi</option>
                                <option>Kritis</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold" style="font-size: 0.875rem;">Gejala Utama</label>
                            <textarea class="form-control rounded-3" rows="2"
                                placeholder="Ringkas gejala yang paling mudah dikenali"></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold" style="font-size: 0.875rem;">Rekomendasi
                                Penanganan</label>
                            <textarea class="form-control rounded-3" rows="2"
                                placeholder="Contoh: Fungisida tembaga, sanitasi lahan, varietas tahan"></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold" style="font-size: 0.875rem;">Thumbnail
                                Penyakit</label>
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
@endsection