@extends('master.header')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @push('style')
        <link rel="stylesheet" href="{{ asset('assets/leaflet/leaflet.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/leaflet/control-eocoder/Control.Geocoder.css') }}">

        <style>
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

            body {
                font-family: 'Poppins', sans-serif;
                background-color: #f8fafc;
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
                position: absolute;
                bottom: 20px;
                left: 20px;
                z-index: 1000;
                background: white;
                padding: 10px 15px;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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

    <div class="container mx-auto p-6">
        <div class="flex flex-wrap justify-between items-start mb-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Peta Sebaran Hama</h1>
                <p class="text-slate-500">Visualisasi geografis persebaran serangan hama dan penyakit di wilayah kerja.</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="flex bg-white p-1 rounded-xl shadow-sm border">
                    <button
                        class="flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 rounded-lg font-medium border border-emerald-100">
                        <i class="fas fa-map-marker-alt"></i> Titik
                    </button>
                    <button
                        class="flex items-center gap-2 px-4 py-2 text-slate-500 hover:bg-gray-50 rounded-lg font-medium">
                        <i class="fas fa-fire"></i> Heatmap
                    </button>
                </div>

                <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-xl shadow-sm border text-slate-600">
                    <i class="far fa-calendar opacity-40"></i>
                    <span class="text-sm font-semibold">Jan 2026 - Feb 2026</span>
                </div>

                <button class="p-3 bg-white rounded-xl shadow-sm border hover:bg-gray-50">
                    <i class="fas fa-expand text-slate-500"></i>
                </button>
            </div>
        </div>

        <div class="relative overflow-hidden shadow-xl rounded-2xl border border-white">
            <div id="map"></div>

            <div class="floating-filter p-6">
                <div class="flex items-center gap-2 mb-6 border-b pb-4">
                    <i class="fas fa-filter text-emerald-600"></i>
                    <span class="font-bold text-slate-700 uppercase tracking-wider text-xs">Filter Peta</span>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Tipe Hama</label>
                        <select
                            class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                            <option>Semua</option>
                        </select>
                    </div>

                    <div>
                        <div class="flex justify-between mb-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase">Radius Analisis</label>
                            <span class="text-xs font-bold text-slate-700">5km</span>
                        </div>
                        <input type="range" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    </div>

                    <div class="pt-2 space-y-2">
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-500 font-medium">Total Titik:</span>
                            <span class="font-bold text-slate-800">8</span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-500 font-medium">Wilayah Terdampak:</span>
                            <span class="font-bold text-slate-800">12 Desa</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="legend-card flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                    <span class="text-[10px] font-bold text-slate-600 uppercase">Kritis</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                    <span class="text-[10px] font-bold text-slate-600 uppercase">Waspada</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                    <span class="text-[10px] font-bold text-slate-600 uppercase">Normal</span>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/leaflet/leaflet.js') }}"></script>
        <script src="{{ asset('assets/leaflet/control-eocoder/Control.Geocoder.js') }}"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var map = L.map('map', { zoomControl: false }).setView([-6.193, 106.832], 14);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

                const locations = [
                    { coords: [-6.190, 106.824], color: '#f59e0b' }, // Waspada
                    { coords: [-6.200, 106.832], color: '#f43f5e' }, // Kritis
                    { coords: [-6.220, 106.820], color: '#f43f5e' }
                ];

                locations.forEach(loc => {
                    L.circle(loc.coords, {
                        color: loc.color,
                        fillColor: loc.color,
                        fillOpacity: 0.2,
                        radius: 500
                    }).addTo(map);
                    L.marker(loc.coords).addTo(map);
                });
            });
        </script>
    @endpush

@endsection