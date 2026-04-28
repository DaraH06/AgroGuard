@extends('master.header')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

@push('style')
<link rel="stylesheet" href="{{ asset('assets/leaflet/leaflet.css') }}">
<link rel="stylesheet" href="{{ asset('assets/leaflet/control-eocoder/Control.Geocoder.css') }}">

<style>
    .kosong {
        width: 200px;
    }

    .kotak {
        --warna: white;
        display: inline-block;
        height: 14px;
        width: 14px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        vertical-align: middle;
    }

    .map-wrapper {
        position: relative !important;
        width: 100%;
        height: 600px;
    }

    #map {
        height: 600px;
        width: 100%;
        border-radius: 1rem;
        z-index: 1;
    }

    .legend-card {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 10px;
    }

    /* Style for the active button toggle */
    .btn-mode.active {
        background-color: #ecfdf5 !important;
        /* bg-emerald-50 */
        color: #059669 !important;
        /* text-emerald-600 */
        border: 1px solid #d1fae5 !important;
        /* border-emerald-100 */
    }

    /* Legend container */
    #legenda {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1.5rem;
        padding: 1rem;
        width: 100%;
    }
</style>
@endpush

<div class="container-fluid px-0">
    <div class="flex flex-wrap justify-between items-start mb-6">
        <div>
            <h4 class="text-3xl fw-bold" style="color: #2b5e3b;">Peta Sebaran Hama</h1>
                <p class="text-slate-500">Visualisasi geografis persebaran serangan hama dan penyakit di wilayah kerja.
                </p>
        </div>

        <div class="flex items-center gap-3">
            <div class="d-flex bg-white p-1 rounded-xl shadow-sm border align-items-center justify-content-between"
                style="min-width: 420px;">
                <div class="d-flex px-2 gap-1" id="toggle-peta">
                    <button id="btn-titik"
                        class="btn-mode active flex items-center gap-2 px-4 py-2 rounded-[10px] font-medium border border-transparent transition-all">
                        <i class="fas fa-map-marker-alt"></i> Titik
                    </button>
                    <button id="btn-heatmap"
                        class="btn-mode flex items-center gap-2 px-4 py-2 text-slate-500 hover:bg-gray-50 rounded-[10px] font-medium border border-transparent transition-all">
                        <i class="fas fa-fire"></i> Heatmap
                    </button>
                </div>

                <div class="d-flex align-items-center ms-auto">
                    <div class="vr mx-2" style="height: 30px; opacity: 0.1;"></div>
                    <div class="p-2 d-flex align-items-center">
                        <label for="tahun"
                            class="form-label px-2 mb-0 text-xs font-bold text-slate-400 uppercase tracking-wider">Tahun</label>
                        <select id="tahun" class="form-select form-select-sm"
                            style="width: 100px; border: none; font-weight: bold; cursor: pointer;">
                            @for ($i = date('Y') + 2; $i >= 2010; $i--)
                            <option value="{{ $i }}" {{ $i==date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="relative overflow-hidden shadow-xl rounded-2xl border border-white">
        <div class="relative">
            <div id="map" style="height: 600px; width: 100%; z-index: 0;"></div>

            <div class="bg-white rounded-b-2xl border-t border-slate-50">
                <div id="legenda"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/leaflet/leaflet.js') }}"></script>
<script src="{{ asset('assets/leaflet/control-eocoder/Control.Geocoder.js') }}"></script>
<script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>
<script src="{{ asset('js/map-visualisasi.js') }}"></script>
@endpush
@endsection