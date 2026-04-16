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
                /* Sesuaikan */
            }

            .floating-filter {
                position: absolute !important;
                top: 10px !important;
                left: 10px !important;
            }

            #map {
                height: 600px;
                width: 100%;
                border-radius: 1rem;
                z-index: 1;
            }

            /* Custom UI untuk filter yang melayang di atas peta */
            .floating-filter {
                position: absolute;
                top: 20px;
                left: 20px;
                z-index: 1000;
                width: 320px;
                background: white;
                border-radius: 15px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }

            .legend-card {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 5px 150px;
            }

            /* Styling Slider Hijau */
            input[type='range']::-webkit-slider-runnable-track {
                background: #10b981;
                height: 8px;
                border-radius: 5px;
            }

            input[type='range']::-webkit-slider-thumb {
                -webkit-appearance: none;
                height: 18px;
                width: 18px;
                background: #10b981;
                border: 2px solid white;
                border-radius: 50%;
                margin-top: -5px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            }
        </style>
    @endpush

    <div class="container-fluid px-0">
        <div class="flex flex-wrap justify-between items-start mb-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Peta Sebaran Hama</h1>
                <p class="text-slate-500">Visualisasi geografis persebaran serangan hama dan penyakit di wilayah kerja.</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="d-flex bg-white p-1 rounded-xl shadow-sm border">
                    <div class="d-flex px-2">
                        <button
                            class="flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 rounded-lg font-medium border border-emerald-100">
                            <i class="fas fa-map-marker-alt"></i> Titik
                        </button>
                        <button
                            class="flex items-center gap-2 px-4 py-2 text-slate-500 hover:bg-gray-50 rounded-lg font-medium">
                            <i class="fas fa-fire"></i> Heatmap
                        </button>
                    </div>
                    <div class="ms-auto p-2 d-flex">
                        <label for="yearInput" class="form-label px-2">Select Year</label>
                        <input id="tahun" type="number" style="width: 80px;" class="form-control" min="2010" step="1" value="{{ date('Y') }}">
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden shadow-xl rounded-2xl border border-white">
            <div class="relative">
                <div id="map" style="height: 500px; width: 100%; z-index: 0;"></div>

                {{-- Legend: overlay di bawah kiri --}}
                <div class="bg-white rounded-xl shadow d-flex flex-row justify-around items-center">
                    <div id="legenda"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/leaflet/leaflet.js') }}"></script>
        <script src="{{ asset('assets/leaflet/control-eocoder/Control.Geocoder.js') }}"></script>
        <script src="{{ asset('js/map-visualisasi.js') }}"></script>
    @endpush
@endsection