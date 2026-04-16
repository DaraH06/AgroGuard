@extends('master.header')

@section('content')
<style>
    .tabel-kontainer {
        width: 100%;
        max-height: 300px;
        overflow-y: auto;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
    }
    /* Styling khusus agar input month terlihat seperti tombol pill hijau */
    .date-pill {
        background-color: #e6f7ef; /* Hijau muda */
        border: none;
        border-radius: 50px;
        padding: 6px 15px;
        color: #16a34a; /* Hijau tua */
        font-weight: 600;
        font-size: 13px;
        outline: none;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
    }

    .date-pill::-webkit-calendar-picker-indicator {
        cursor: pointer;
        filter: invert(48%) sepia(79%) saturate(2476%) hue-rotate(114deg) brightness(91%) contrast(85%);
    }

    .date-label {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 2px;
    }
</style>

<div class="container-fluid px-0">

    <div class="d-flex justify-content-between align-items-end mb-4">
        <h4 class="mb-0 fw-semibold" style="color: #2b5e3b;">Dashboard</h4>
        
        <div class="d-flex align-items-center gap-3">
            <div class="text-end" style="align-content: center;">
                <div class="date-label">Bulan Awal</div>
                <input id="bulanAwal" type="month" class="date-pill" value="{{ date('Y-m') }}">
            </div>
            
            <div class="align-self-end mb-1 text-muted fw-bold">-</div>
            
            <div class="text-end">
                <div class="date-label">Bulan Akhir</div>
                <input id="bulanAkhir" type="month" class="date-pill" value="{{ date('Y-m') }}">
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-file-medical text-success" style="font-size: 1.8rem;"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted mb-1">Rata-rata Akurasi</h6>
                        <h3 id="ringkasan_akurasi" class="mb-0 fw-bold">****</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-map text-info" style="font-size: 1.8rem;"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted mb-1">Lokasi Terpantau</h6>
                        <h3 id="lokasi_terpantau" class="mb-0 fw-bold">****</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-exclamation-triangle text-warning" style="font-size: 1.8rem;"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted mb-1">Laporan Aktif</h6>
                        <h3 id="laporan_aktif" class="mb-0 fw-bold">****</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 style="text-align: center;" class="mb-0 fw-semibold">Laporan Tabular 20 Teratas</h5>
                </div>
                <div style="overflow-y: scroll;" class="card-body tabel-kontainer">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Lokasi</th>
                                <th>Jenis Penyakit</th>
                                <th>Keyakinan</th>
                            </tr>
                        </thead>
                        <tbody id="data_tabel">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-semibold">Aksi Cepat</h5>
                </div>
                <div class="card-body d-grid gap-3">
                    <button id="export" class="btn btn-warning w-100 py-3 fw-semibold">
                        <i class="bi bi-download me-2"></i> Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Statistik Jenis Penyakit</h6>
                    <div class="loading"></div>
                    <canvas id="penyakitChart" style="height:300px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Laporan per Hari</h6>
                    <div class="loading"></div>
                    <canvas id="laporanChart" style="height:300px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endpush