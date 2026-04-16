document.addEventListener('DOMContentLoaded', function () {

    const elemenTahun = document.getElementById('tahun');
    let tahun = elemenTahun.value;
    elemenTahun.addEventListener('change', ()=>{
        getDataVisualisasi(tahun);
    })
    getDataVisualisasi(tahun);
});

function getDataVisualisasi(tahun) {
    fetch(`/api_admin/map?tahun=${tahun}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            }
    }).then(response => response.json())
    .then(data => data.status ? generateMap(data.data.visual_map) : console.log('kosong/error'))
    .catch(e => console.error(e));
}

function generateWarna(warna, label){
    const hue = warna * 20;
    const param1 = hue % 360;

    let legenda = document.getElementById('legenda');
    legenda.innerHTML += `
        <div class="legend-card flex items-center gap-2">
            <div class="kotak" style="background-color: hsl(${param1}, 70%, 60%)"></div>
            <span class="text-[10px] font-bold text-slate-600 uppercase">${label}</span>
        </div>`

    return param1;
}

function generateMap(data) {

    const labels = Object.keys(data);

    var map = L.map('map', { zoomControl: false }).setView([-8.160, 113.722], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);


    const FilterControl = L.Control.extend({
        options: {
            position: 'topright'
        },
        onAdd: ()=> {
            const container = L.DomUtil.create('div', 'leaflet-filter-panel');
            // Cegah klik/scroll map saat interaksi dengan panel
            L.DomEvent.disableClickPropagation(container);

            container.innerHTML = `
                        <div class="bg-white flex flex-col items-center justify-center shadow-sm" style="width:175px; height:150px;">
                            <div class="w-full px-3">
                                <div class="text-center gap-2 mb-1 border-b pb-1">
                                    <i class="fas fa-filter text-emerald-600"></i>
                                    <span class="font-bold text-slate-700 uppercase tracking-wider text-xs">Filter Peta</span>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2 text-center">Tipe Hama</label>
                                        <select class="w-full p-2 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none">
                                            <option>Semua</option>
                                        </select>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <label class="text-[10px] font-bold text-slate-400 uppercase">Radius</label>
                                            <span class="text-xs font-bold text-slate-700">5km</span>
                                        </div>
                                        <input type="range" class="w-full cursor-pointer">
                                    </div>
                                    <div class="pt-2 space-y-1">
                                        <div class="flex justify-between text-xs">
                                            <span class="text-slate-500">Total Titik:</span>
                                            <span class="font-bold text-slate-800">8</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
            return container;
        }
    });
    new FilterControl().addTo(map);

    console.log(data);

    labels.forEach((label, i) => {
        warna = generateWarna(i * i, label);
        const warnawarni = `hsl(${warna}, 70%, 60%)`
        
        data[label].forEach(item => {
            const koor = item.lokasi.koordinat;
            L.circleMarker(koor, {
                color: '#fff',
                fillColor: warnawarni,
                fillOpacity: 0.8,
                weight:2,
                opacity:1,
                radius: 18
            }).addTo(map);
        })
    });
}