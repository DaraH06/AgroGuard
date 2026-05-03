<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AgroGuard - Sistem Informasi Penyakit Tanaman</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/image/ikon.png') }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Font: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
</head>

<div>
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr style="border-bottom: 1px solid #f0f0f0;">
                <th class="px-4 py-3 text-uppercase text-muted fw-semibold">
                    Metode
                </th>
                <th class="px-4 py-3 text-uppercase text-muted fw-semibold">
                    Fitur
                </th>
                <th class="px-4 py-3 text-uppercase text-muted fw-semibold">
                    Data
                </th>
                <th class="px-4 py-3 text-uppercase text-muted fw-semibold">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody>
            <tr style="border-bottom: 1px solid #f5f5f5;">
                <td class="px-4 py-3">GET</td>
                <td class="px-4 py-3">Data Map</td>
                <td class="px-4 py-3">Tahun
                    <input id="data1" type="number" min="2020" max="2035">
                </td>
                <td class="px-4 py-3">
                    <button type="button" onclick="getData(
                    document.getElementById('data1').value, 'api_admin/map?tahun')"
                        class="btn btn-sm btn-outline-success rounded-3">
                        Cek
                    </button>
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #f5f5f5;">
                <td class="px-4 py-3">GET</td>
                <td class="px-4 py-3">Data User</td>
                <td class="px-4 py-3">Semua
                </td>
                <td class="px-4 py-3">
                    <button type="button" onclick="getData(false, 'testing/users')"
                        class="btn btn-sm btn-outline-success rounded-3">
                        Cek
                    </button>
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #f5f5f5;">
                <td class="px-4 py-3">POST</td>
                <td class="px-4 py-3">Data Dashboard</td>
                <td class="px-4 py-3">Bulan
                    <input id="data2" type="month" class="date-pill" value="{{ date('Y-m') }}">
                </td>
                <td class="px-4 py-3">
                    <button type="button" onclick="postData(
                    document.getElementById('data2').value, 'api_admin/dashboard')"
                        class="btn btn-sm btn-outline-success rounded-3">
                        Cek
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    function newTab(data) {
        const newT = window.open();
        newT.document.open();
        newT.document.write(`<pre>${JSON.stringify(data, null, 2)}</pre>`);
        newT.document.close();
    }

    function getData(data, url) {
        let link = url;
        if (data) {
            link = `${url}=${data}`;
        }
        fetch(`/${link}`, {
            method: 'GET',
            headers: { 'Accept': 'application/json' }
        }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    newTab(data);
                } else {
                    console.log('No data found for data ' + data);
                }
            })
            .catch(e => console.error(e));
    }

    function postData(data, url) {
        let payload = { 'bulan_mulai': data, 'bulan_akhir': data };
        fetch(`/${url}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            },
            body: JSON.stringify(payload)
        }).then(response => response.json())
            .then(data => {
                newTab(data)
            })
            .catch(err => console.error(err));
    }
</script>