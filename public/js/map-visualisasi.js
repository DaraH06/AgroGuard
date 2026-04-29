let map;
let markerLayer = L.layerGroup();
let heatmapLayer = L.layerGroup();
let currentRawData = {};
let currentMode = 'titik'; // 'titik' or 'heatmap'

document.addEventListener('DOMContentLoaded', function () {
    const elemenTahun = document.getElementById('tahun');
    
    // Initial load
    getDataVisualisasi(elemenTahun.value);

    // Filter Tahun
    elemenTahun.addEventListener('change', () => {
        getDataVisualisasi(elemenTahun.value);
    });

    // Toggle Titik vs Heatmap
    document.getElementById('btn-titik').addEventListener('click', () => switchMode('titik'));
    document.getElementById('btn-heatmap').addEventListener('click', () => switchMode('heatmap'));
});

function switchMode(mode) {
    currentMode = mode;
    const btnTitik = document.getElementById('btn-titik');
    const btnHeatmap = document.getElementById('btn-heatmap');

    if (mode === 'titik') {
        btnTitik.classList.add('active');
        btnHeatmap.classList.remove('active');
        if (map) {
            map.removeLayer(heatmapLayer);
            map.addLayer(markerLayer);
        }
    } else {
        btnHeatmap.classList.add('active');
        btnTitik.classList.remove('active');
        if (map) {
            map.removeLayer(markerLayer);
            map.addLayer(heatmapLayer);
        }
    }
    
    const selectHama = document.getElementById('select-hama');
    if (selectHama) updateMapLayers(selectHama.value);
}

function getDataVisualisasi(tahun) {
    fetch(`/api_admin/map?tahun=${tahun}`, {
        method: 'GET',
        headers: { 'Accept': 'application/json' }
    }).then(response => response.json())
    .then(data => {
        if (data.status) {
            currentRawData = data.data.visual_map;
            generateMap(currentRawData);
        } else {
            console.log('No data found for year ' + tahun);
            markerLayer.clearLayers();
            heatmapLayer.clearLayers();
            document.getElementById('total-titik').textContent = '0';
        }
    })
    .catch(e => console.error(e));
}

function generateMap(data) {
    const labels = Object.keys(data);
    
    if (!map) {
        map = L.map('map', { zoomControl: false }).setView([-8.160, 113.722], 10);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        markerLayer.addTo(map);

        const FilterControl = L.Control.extend({
            options: { position: 'topright' },
            onAdd: () => {
                const container = L.DomUtil.create('div', 'leaflet-filter-panel');
                L.DomEvent.disableClickPropagation(container);
                container.innerHTML = `
                    <div class="bg-white flex flex-col items-center justify-center shadow-xl rounded-2xl border border-slate-200" style="width:180px; padding: 16px;">
                        <div class="w-full">
                            <div class="text-center gap-2 mb-3 border-b border-slate-100 pb-2">
                                <i class="fas fa-filter text-emerald-600"></i>
                                <span class="font-bold text-slate-800 uppercase tracking-widest text-[10px]">Filter Peta</span>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-[9px] font-bold text-slate-400 uppercase mb-2">Tipe Hama</label>
                                    <select id="select-hama" class="w-full p-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-semibold text-slate-700 outline-none cursor-pointer">
                                        <option value="all">Semua Jenis</option>
                                    </select>
                                </div>
                                <div class="pt-2 border-t border-slate-100">
                                    <div class="flex justify-between items-center">
                                        <span class="text-[10px] font-bold text-slate-500 uppercase">Total Data</span>
                                        <span id="total-titik" class="font-black text-emerald-600 text-sm">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                return container;
            }
        });
        new FilterControl().addTo(map);

        document.addEventListener('change', (e) => {
            if (e.target.id === 'select-hama') {
                updateMapLayers(e.target.value);
            }
        });
    }

    // Populate Dropdown
    const selectHama = document.getElementById('select-hama');
    const currentValue = selectHama.value;
    selectHama.innerHTML = '<option value="all">Semua Jenis</option>';
    labels.forEach(label => {
        const option = document.createElement('option');
        option.value = label;
        option.textContent = label;
        if (label === currentValue) option.selected = true;
        selectHama.appendChild(option);
    });

    // Render Legenda
    const containerLegenda = document.getElementById('legenda');
    containerLegenda.innerHTML = '';
    labels.forEach((label, i) => {
        const hue = ((2+i) * 45) % 360;
        containerLegenda.innerHTML += `
            <div class="legend-card">
                <div class="kotak" style="background-color: hsl(${hue}, 70%, 60%)"></div>
                <span>${label}</span>
                <span>[${data[label].length}]</span>
            </div>`;
    });

    updateMapLayers(selectHama.value);
}

function updateMapLayers(filterLabel) {
    markerLayer.clearLayers();
    heatmapLayer.clearLayers();
    
    let total = 0;
    const heatData = [];
    const labels = Object.keys(currentRawData);

    labels.forEach((label, i) => {
        if (filterLabel !== 'all' && filterLabel !== label) return;

        const hue = ((2 + i) * 45) % 360;
        const color = `hsl(${hue}, 70%, 60%)`;
        
        currentRawData[label].forEach(item => {
            const koor = item.lokasi.koordinat;
            
            // Titik Mode
            L.circleMarker(koor, {
                color: '#fff',
                fillColor: color,
                fillOpacity: 0.85,
                weight: 2,
                radius: 10
            }).addTo(markerLayer);

            // Heatmap Mode - Increase weight to 1.0
            heatData.push([koor[0], koor[1], 1.0]);
            
            total++;
        });
    });

    if (heatData.length > 0) {
        L.heatLayer(heatData, { 
            radius: 30, 
            blur: 20,
            max: 1.5,
            minOpacity: 0.3,
            gradient: {
                0.1: '#00ff00',
                0.3: '#ffff00',
                0.6: '#ff8c00',
                1.0: '#ff0000'
            } 
        }).addTo(heatmapLayer);
    }

    document.getElementById('total-titik').textContent = total;
}