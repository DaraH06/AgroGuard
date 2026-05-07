@extends('master.header')

@push('style')
    @vite('resources/css/dashboard.css')
@endpush

@section('content')
    <div class="container-fluid px-0">

        {{-- Header --}}
        <div class="dashboard-header">
            <div>
                <h4 class="dashboard-title">Dashboard</h4>
                <p class="dashboard-subtitle">Selamat datang kembali! Berikut ringkasan laporan terbaru.</p>
            </div>

            <div class="date-filter-group">
                <div>
                    <div class="date-label">Bulan Awal</div>
                    <input id="bulanAwal" type="month" class="date-pill" value="{{ date('Y-m') }}">
                </div>
                <span class="date-separator">—</span>
                <div>
                    <div class="date-label">Bulan Akhir</div>
                    <input id="bulanAkhir" type="month" class="date-pill" value="{{ date('Y-m') }}">
                </div>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card stat-card stat-akurasi shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon icon-akurasi">
                            <i class="bi bi-bullseye"></i>
                        </div>
                        <div>
                            <div class="stat-label">Rata-rata Akurasi</div>
                            <div id="ringkasan_akurasi" class="stat-value">****</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card stat-lokasi shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon icon-lokasi">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div>
                            <div class="stat-label">Lokasi Terpantau</div>
                            <div id="lokasi_terpantau" class="stat-value">****</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card stat-laporan shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon icon-laporan">
                            <i class="bi bi-clipboard-data-fill"></i>
                        </div>
                        <div>
                            <div class="stat-label">Laporan Aktif</div>
                            <div id="laporan_aktif" class="stat-value">****</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table & Actions --}}
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card table-card shadow-sm">
                    <div class="card-header border-0">
                        <h5 class="mb-0">
                            <i class="bi bi-table"></i>
                            Laporan Tabular 20 Teratas
                        </h5>
                    </div>
                    <div class="card-body tabel-kontainer p-0">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
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
                <div class="card action-card shadow-sm h-100">
                    <div class="card-header border-0">
                        <h5 class="mb-0">
                            <i class="bi bi-lightning-charge-fill" style="color: #f59e0b;"></i>
                            Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body d-grid gap-3">
                        <button type="button" onclick="ExportTable(document.getElementById('bulanAwal'))" id="export"
                            class="btn btn-export w-100">
                            <i class="bi bi-file-earmark-arrow-down"></i>
                            <span id="teks-export"></span>
                        </button>

                        <div class="info-box">
                            <p><i class="bi bi-info-circle-fill"></i> Export data laporan dalam format Excel (.xlsx) sesuai
                                rentang bulan yang dipilih.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts --}}
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card chart-card shadow-sm">
                    <div class="card-body">
                        <div class="chart-title">
                            <i class="bi bi-bar-chart-fill" style="color: #8b5cf6;"></i>
                            Statistik Jenis Penyakit
                        </div>
                        <div class="chart-subtitle">Distribusi kasus berdasarkan jenis penyakit</div>
                        <div class="loading"></div>
                        <div class="chart-wrapper">
                            <canvas id="penyakitChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card chart-card shadow-sm">
                    <div class="card-body">
                        <div class="chart-title">
                            <i class="bi bi-graph-up" style="color: #2b5e3b;"></i>
                            Laporan per Hari
                        </div>
                        <div class="chart-subtitle">Tren jumlah laporan harian dalam periode terpilih</div>
                        <div class="loading"></div>
                        <div class="chart-wrapper">
                            <canvas id="laporanChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/dashboard.js')
    <script>
        function ExportTable(data) {
            const filename = `{{ date_format(now(), 'Ymd') }}-laporan bulan ${data.value}.xlsx`;

            let url = "{{ route('admin.export', ['filename' => 'FILE']) }}";
            url = url.replace('FILE', filename);
            window.open(`${url}?month_year=${data.value}`, '_blank');
        }
    </script>
@endpush