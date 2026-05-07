/* =============================================
   Dashboard JS - AgroGuard Premium
   ============================================= */
import Chart from 'chart.js/auto';

// Set global Chart.js defaults for a premium look
Chart.defaults.font.family = "'Poppins', sans-serif";
Chart.defaults.font.size = 12;
Chart.defaults.color = '#64748b';
Chart.defaults.plugins.legend.labels.usePointStyle = true;
Chart.defaults.plugins.legend.labels.padding = 16;

let ringkas_akurasi, loka_terpantau, lapor_aktif, tabel_elemen;
let ctx1, ctx2, instance_ctx1 = null, instance_ctx2 = null;

document.addEventListener('DOMContentLoaded', function () {
    ringkas_akurasi = document.getElementById('ringkasan_akurasi');
    loka_terpantau = document.getElementById('lokasi_terpantau');
    lapor_aktif = document.getElementById('laporan_aktif');
    tabel_elemen = document.getElementById('data_tabel');

    loadingView('Memuat....');

    const bulan = document.querySelectorAll('.date-pill');
    ctx1 = document.getElementById('penyakitChart');
    ctx2 = document.getElementById('laporanChart');

    bulan.forEach(function (input) {
        input.addEventListener('change', function () {
            menjalankanAksi();
        });
    });

    menjalankanAksi();
});

function loadingView(x, z = true) {
    document.querySelectorAll('.loading').forEach((el) => {
        el.textContent = z ? 'Sedang memuat data....' : '';
        el.style.display = z ? 'block' : 'none';
    });
    document.querySelectorAll('canvas').forEach(
        (el) => { el.style.opacity = z ? '0' : '1'; });

    if (z) {
        const elements = [ringkas_akurasi, loka_terpantau, lapor_aktif, tabel_elemen];
        elements.forEach(function (el) {
            if (el) {
                el.textContent = x;
            }
        });
    }
}

function menjalankanAksi() {
    let bulanAwal = document.getElementById('bulanAwal');
    let bulanAkhir = document.getElementById('bulanAkhir');
    document.getElementById('teks-export').textContent = ` Export ${bulanAwal.value}`;

    if (bulanAwal && bulanAkhir) {
        let awal = bulanAwal.value;
        let akhir = bulanAkhir.value;

        if (akhir >= awal && akhir !== "") {
            updateDashboard(awal, akhir);
        } else {
            loadingView('Bulan Akhir harus >= Bulan Awal!');
        }
    }
}

function updateDashboard(awal, akhir) {
    let payload = { 'bulan_mulai': awal, 'bulan_akhir': akhir };
    fetch('/api_admin/dashboard', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        },
        body: JSON.stringify(payload)
    }).then(response => response.json())
        .then(data => data.success ? masukkan_data(data.data)
            : data.data == null ?
                loadingView('Data di rentang bulan ini tidak ditemukan') : loadingView(''))
        .catch(err => console.error(err));
}

// Premium color palette
const premiumColors = [
    '#22c55e', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6',
    '#ec4899', '#14b8a6', '#f97316', '#06b6d4', '#84cc16',
    '#a855f7', '#e11d48', '#0ea5e9', '#10b981', '#6366f1'
];

function getListWarna(n) {
    let hasil = [];
    for (let i = 0; i < n; i++) {
        hasil[i] = premiumColors[i % premiumColors.length];
    }
    return hasil;
}

function masukkan_data(data) {
    // Animate stat values
    animateValue(ringkas_akurasi, data.ringkasan_akurasi);
    animateValue(loka_terpantau, data.ringkasan_lokasi);
    animateValue(lapor_aktif, data.total);

    tabel_elemen.innerHTML = '';

    data.data_tabel.forEach((item, index) => {
        let row = `<tr style="animation: fadeInUp 0.3s ease ${index * 0.05}s backwards;">
        <td><span style="color:#475569; font-weight:500;">${item.created_at}</span></td>
        <td><i class="bi bi-geo-alt" style="color:#0ea5e9; margin-right:4px;"></i>Kec. ${item.lokasi.kecamatan}</td>
        <td><span style="background:#fef3c7; color:#92400e; padding:3px 10px; border-radius:20px; font-size:0.8rem; font-weight:600;">${item.hasil_label}</span></td>
        <td><strong style="color:#1e293b;">${item.keyakinan_model}</strong></td>
        </tr>`;
        tabel_elemen.insertAdjacentHTML('beforeend', row);
    });

    loadingView(undefined, false);

    if (instance_ctx1 || instance_ctx2) {
        instance_ctx1.destroy();
        instance_ctx2.destroy();
    }

    let keys = [
        Object.keys(data.ringkasan_label),
        Object.keys(data.ringkasan_harian)];
    let values = [
        Object.values(data.ringkasan_label),
        Object.values(data.ringkasan_harian)];

    // BAR CHART - Premium
    if (ctx1) {
        const barColors = getListWarna(keys[0].length);
        instance_ctx1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: keys[0],
                datasets: [{
                    label: 'Jumlah Kasus',
                    data: values[0],
                    backgroundColor: barColors.map(c => c + 'CC'),
                    borderColor: barColors,
                    borderWidth: 2,
                    borderRadius: 10,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#f8fafc',
                        bodyColor: '#e2e8f0',
                        borderColor: '#334155',
                        borderWidth: 1,
                        cornerRadius: 12,
                        padding: 12,
                        displayColors: true,
                        boxPadding: 4
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9',
                            drawBorder: false
                        },
                        ticks: { padding: 8 }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            padding: 8,
                            maxRotation: 45
                        }
                    }
                }
            }
        });
    }

    // LINE CHART - Premium
    if (ctx2) {
        instance_ctx2 = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: keys[1],
                datasets: [{
                    label: 'Jumlah Laporan',
                    data: values[1],
                    borderColor: '#2b5e3b',
                    backgroundColor: createGradient(ctx2),
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#2b5e3b',
                    pointBorderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#2b5e3b',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 3,
                    borderWidth: 3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1200,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#f8fafc',
                        bodyColor: '#e2e8f0',
                        borderColor: '#334155',
                        borderWidth: 1,
                        cornerRadius: 12,
                        padding: 12,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9',
                            drawBorder: false
                        },
                        ticks: { padding: 8 }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { padding: 8 }
                    }
                }
            }
        });
    }
}

function createGradient(canvas) {
    const ctx = canvas.getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(43, 94, 59, 0.3)');
    gradient.addColorStop(0.5, 'rgba(43, 94, 59, 0.1)');
    gradient.addColorStop(1, 'rgba(43, 94, 59, 0)');
    return gradient;
}

function animateValue(element, finalValue) {
    if (!element) return;
    element.style.transition = 'opacity 0.3s, transform 0.3s';
    element.style.opacity = '0';
    element.style.transform = 'scale(0.8)';

    setTimeout(() => {
        element.textContent = finalValue;
        element.style.opacity = '1';
        element.style.transform = 'scale(1)';
    }, 200);
}
