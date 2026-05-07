@extends('master.header')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @push('style')
        <link rel="stylesheet" href="{{ asset('assets/leaflet/leaflet.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/leaflet/control-eocoder/Control.Geocoder.css') }}">

        @vite('resources/css/sebaran.css')
    @endpush

    <div class="container-fluid px-0">
        <div class="page-header flex flex-wrap justify-between items-start mb-6">
            <div>
                <h4 class="page-title">Peta Sebaran Hama</h4>
                <p class="page-subtitle">Visualisasi geografis persebaran serangan hama dan penyakit di wilayah kerja.</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="d-flex bg-white p-1 shadow-sm border align-items-center justify-content-between"
                    style="min-width: 420px; border-radius: 12px; border-color: #e2e8f0 !important;">
                    <div class="d-flex px-1 gap-2" id="toggle-peta" style="height: 100%;">
                        <button id="btn-titik"
                            class="btn-mode active flex items-center justify-center px-4 py-2 font-medium transition-all" style="border-radius: 8px;">
                            Titik
                        </button>
                        <button id="btn-heatmap"
                            class="btn-mode flex items-center justify-center px-4 py-2 font-medium transition-all" style="border-radius: 8px;">
                            Heatmap
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
                                    <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
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
        @vite('resources/js/sebaran.js')
    @endpush
@endsection