let ringkas_akurasi, loka_terpantau, lapor_aktif, tabel_elemen;
let ctx1, ctx2, instance_ctx1 =null, instance_ctx2 =null;

document.addEventListener('DOMContentLoaded', function(){
    ringkas_akurasi = document.getElementById('ringkasan_akurasi');
    loka_terpantau = document.getElementById('lokasi_terpantau');
    lapor_aktif = document.getElementById('laporan_aktif');
    tabel_elemen = document.getElementById('data_tabel');

    loadingView('Memuat....');

    const bulan = document.querySelectorAll('.date-pill');
    ctx1 = document.getElementById('penyakitChart');
    ctx2 = document.getElementById('laporanChart');

    bulan.forEach(function(input) {
        input.addEventListener('change', function(){
            menjalankanAksi();
        })
    })
    menjalankanAksi();
})

function loadingView(x, z = true){
    document.querySelectorAll('loading').forEach((x)=>{
        x.textContent = z ? 'Sedang memuat data....' : 'dfdghgf';
        x.style.display = z ? 'block' : 'none';
    })
    document.querySelectorAll('canvas').forEach(
        (x)=> {x.style.opacity = z ? '0' : '1'});

    if(z){
        element = [ringkas_akurasi, loka_terpantau, lapor_aktif, tabel_elemen];
        element.forEach(function(el){
            if(el){
                el.textContent = x;
            }
        })
    }

    }

function menjalankanAksi(){
    let bulanAwal = document.getElementById('bulanAwal');
    let bulanAkhir = document.getElementById('bulanAkhir');

    if(bulanAwal && bulanAkhir){
        let awal = bulanAwal.value;
        let akhir = bulanAkhir.value;

        if(akhir >= awal && akhir !==""){
            updateDashboard(awal, akhir);
        }else{
            loadingView('Bulan Akhir harus >= Bulan Awal!');
        }
    }
}

function updateDashboard(awal, akhir){
    let payload = {'bulan_mulai' : awal, 'bulan_akhir':akhir};
    fetch('/api_admin/dashboard', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
            .getAttribute('content')
        },
        body: JSON.stringify(payload)
    }).then(response => response.json())
    .then(data => data.status ? masukkan_data(data.data) 
    : data.data ==null ? 
    loadingView('Data di rentang bulan ini tidak ditemukan') : loadingView(''))
    .catch(err => console.error(err));
}

function masukkan_data(data){
    console.log(data);

    ringkas_akurasi.textContent = data.ringkasan_akurasi;
    loka_terpantau.textContent = data.ringkasan_lokasi;
    lapor_aktif.textContent = data.total;
    tabel_elemen.innerHTML = '';

    data.data_tabel.forEach(item =>{
        let row = `<tr>
        <td>${item.created_at}</td>
        <td>Kec. ${item.lokasi.kecamatan}</td>
        <td>${item.hasil_label}</td>
        <td>${item.keyakinan_model}</td>
        </tr>`
        tabel_elemen.insertAdjacentHTML('beforeend', row);
    })

    loadingView(undefined, false);

    if(instance_ctx1 || instance_ctx2){
        instance_ctx1.destroy();
        instance_ctx2.destroy();
    }

        // BAR CHART
    if (ctx1) {
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: Object.keys(data.ringkasan_label),
                datasets: [{
                    label: 'Jumlah Kasus',
                    data: Object.values(data.ringkasan_label),
                    backgroundColor: ['#2b5e3b','#4CAF50','#A5D6A7']
                }]
            }
        });
    }

    // LINE CHART
    if (ctx2) {
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: Object.keys(data.ringkasan_harian),
                datasets: [{
                    label: 'Jumlah Laporan',
                    data: Object.values(data.ringkasan_harian),
                    borderColor: '#2b5e3b',
                    backgroundColor: 'rgba(43,94,59,0.2)',
                    tension: 0.4,
                    fill: true
                }]
            }
        });
    }
}