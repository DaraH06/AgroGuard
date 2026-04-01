<!-- resources/views/admin/dashboard.blade.php -->
@extends('master.header')

@section('content')
<div class="container-fluid px-0">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-semibold" style="color: #2b5e3b;">Dashboard</h4>
        <div>
            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                <i class="bi bi-calendar3 me-2"></i>
                {{ date('d F Y') }}
            </span>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                                <i class="bi bi-file-medical text-success" style="font-size: 1.8rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Penyakit</h6>
                            <h3 class="mb-0 fw-bold">24</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                                <i class="bi bi-map text-info" style="font-size: 1.8rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Lokasi Terpantau</h6>
                            <h3 class="mb-0 fw-bold">156</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                                <i class="bi bi-exclamation-triangle text-warning" style="font-size: 1.8rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Laporan Aktif</h6>
                            <h3 class="mb-0 fw-bold">12</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row g-4">
        <!-- Recent Reports -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-semibold">Laporan Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Lokasi</th>
                                    <th>Jenis Penyakit</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Kec. Cibadak</td>
                                    <td>Penyakit Daun</td>
                                    <td>12 Mar 2026</td>
                                    <td><span class="badge bg-warning">Menunggu</span></td>
                                </tr>
                                <tr>
                                    <td>Kec. Cicantayan</td>
                                    <td>Busuk Batang</td>
                                    <td>11 Mar 2026</td>
                                    <td><span class="badge bg-success">Selesai</span></td>
                                </tr>
                                <tr>
                                    <td>Kec. Sukaraja</td>
                                    <td>Hama Wereng</td>
                                    <td>10 Mar 2026</td>
                                    <td><span class="badge bg-info">Diproses</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-semibold">Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <button class="btn btn-outline-success text-start py-3">
                            <i class="bi bi-plus-circle me-2"></i>
                            Tambah Laporan Baru
                        </button>
                        <button class="btn btn-outline-info text-start py-3">
                            <i class="bi bi-pencil-square me-2"></i>
                            Update Data Penyakit
                        </button>
                        <button class="btn btn-outline-warning text-start py-3">
                            <i class="bi bi-download me-2"></i>
                            Ekspor Laporan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection