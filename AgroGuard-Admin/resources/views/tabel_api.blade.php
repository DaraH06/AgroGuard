@php
    $apiList = [
        [
            'method' => 'GET',
            'feature' => 'Data Map',
            'controller' => 'dashboard@mapVisualisasi',
            'url' => route('api_admin.map'),
            'inputs' => [
                ['name' => 'tahun', 'label' => 'Tahun', 'type' => 'number', 'value' => date('Y'), 'min' => 2010, 'max' => 2035],
            ],
        ],
        [
            'method' => 'POST',
            'feature' => 'Data Dashboard',
            'controller' => 'dashboard@index',
            'url' => route('api_admin.dashboard'),
            'payload' => 'dashboard_month',
            'inputs' => [
                ['name' => 'bulan', 'label' => 'Bulan', 'type' => 'month', 'value' => date('Y-m')],
            ],
        ],
        [
            'method' => 'GET',
            'feature' => 'Data User',
            'controller' => 'ManajemenUserController@getUsers',
            'url' => route('test.users'),
            'inputs' => [],
        ],
        [
            'method' => 'GET',
            'feature' => 'Data Penyakit',
            'controller' => 'crud_penyakit@index',
            'url' => route('admin.manajemen-penyakit'),
            'inputs' => [],
        ],
        [
            'method' => 'GET',
            'feature' => 'Data Upload Flutter',
            'controller' => 'FlutterImageController@index',
            'url' => route('uploads'),
            'inputs' => [],
        ],
        [
            'method' => 'POST',
            'feature' => 'Upload Foto',
            'controller' => 'FlutterImageController@upload',
            'url' => route('upload'),
            'payload' => 'form_data',
            'inputs' => [
                ['name' => 'image', 'label' => 'Foto', 'type' => 'file', 'value' => '', 'accept' => 'image/jpeg,image/png,image/jpg,image/gif'],
            ],
        ],
        [
            'method' => 'GET',
            'feature' => 'Kondisi Penyakit Sekitar',
            'controller' => 'KondisiController@index',
            'url' => route('kondisi'),
            'inputs' => [
                ['name' => 'kabupaten', 'label' => 'Kabupaten', 'type' => 'text', 'value' => '', 'placeholder' => 'Opsional'],
            ],
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AgroGuard - Testing API</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/image/ikon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: #f6f8f7;
            color: #1f2933;
            font-family: 'Poppins', sans-serif;
        }

        .page-shell {
            max-width: 1180px;
            margin: 0 auto;
            padding: 32px 18px;
        }

        .toolbar {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 20px;
        }

        .toolbar h1 {
            margin: 0;
            font-size: 1.45rem;
            font-weight: 700;
        }

        .toolbar p {
            max-width: 680px;
            margin: 6px 0 0;
            color: #60706b;
            font-size: .92rem;
        }

        .table-wrap {
            overflow: hidden;
            border: 1px solid #dfe8e3;
            border-radius: 8px;
            background: #fff;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #edf4ef;
            color: #53645d;
            font-size: .76rem;
            letter-spacing: 0;
        }

        .method-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 58px;
            padding: 5px 9px;
            border-radius: 6px;
            font-size: .78rem;
            font-weight: 700;
        }

        .method-get {
            background: #e7f1ff;
            color: #0b5ed7;
        }

        .method-post {
            background: #e8f6ee;
            color: #167b45;
        }

        .endpoint-path {
            color: #647067;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: .82rem;
            word-break: break-all;
        }

        .input-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
            min-width: 240px;
        }

        .input-grid label {
            display: block;
            margin-bottom: 4px;
            color: #60706b;
            font-size: .74rem;
            font-weight: 600;
        }

        .input-grid input {
            width: 100%;
            min-height: 36px;
            border: 1px solid #cfdbd5;
            border-radius: 6px;
            padding: 6px 9px;
            font-size: .86rem;
        }

        .empty-input {
            color: #8a9690;
            font-size: .86rem;
        }

        @media (max-width: 768px) {
            .toolbar {
                align-items: stretch;
                flex-direction: column;
            }

            .table-wrap {
                overflow-x: auto;
            }

            .table {
                min-width: 860px;
            }
        }
    </style>
</head>

<body>
    <main class="page-shell">
        <div class="toolbar">
            <div>
                <h1>Testing API Pengambil Data</h1>
                <p>Daftar ini hanya berisi endpoint controller yang mengambil data.</p>
            </div>
        </div>

        <div class="table-wrap">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-uppercase fw-semibold">Metode</th>
                        <th class="px-4 py-3 text-uppercase fw-semibold">Fitur</th>
                        <th class="px-4 py-3 text-uppercase fw-semibold">Controller</th>
                        <th class="px-4 py-3 text-uppercase fw-semibold">Parameter</th>
                        <th class="px-4 py-3 text-uppercase fw-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apiList as $index => $api)
                        <tr>
                            <td class="px-4 py-3">
                                <span class="method-badge method-{{ strtolower($api['method']) }}">{{ $api['method'] }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="fw-semibold">{{ $api['feature'] }}</div>
                                <div class="endpoint-path">{{ parse_url($api['url'], PHP_URL_PATH) }}</div>
                            </td>
                            <td class="px-4 py-3">{{ $api['controller'] }}</td>
                            <td class="px-4 py-3">
                                @if (count($api['inputs']) > 0)
                                    <div class="input-grid">
                                        @foreach ($api['inputs'] as $input)
                                            <div>
                                                <label for="api-{{ $index }}-{{ $input['name'] }}">{{ $input['label'] }}</label>
                                                <input
                                                    id="api-{{ $index }}-{{ $input['name'] }}"
                                                    name="{{ $input['name'] }}"
                                                    type="{{ $input['type'] }}"
                                                    value="{{ $input['value'] }}"
                                                    placeholder="{{ $input['placeholder'] ?? '' }}"
                                                    @isset($input['accept']) accept="{{ $input['accept'] }}" @endisset
                                                    @isset($input['min']) min="{{ $input['min'] }}" @endisset
                                                    @isset($input['max']) max="{{ $input['max'] }}" @endisset
                                                >
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="empty-input">Tidak ada parameter</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <button type="button"
                                    class="btn btn-sm btn-outline-success rounded-2"
                                    data-api='@json($api)'
                                    data-index="{{ $index }}"
                                    onclick="requestApi(this)">
                                    <i class="bi bi-send me-1"></i>
                                    Cek
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <script>
        function getInputValues(index) {
            const inputs = document.querySelectorAll(`[id^="api-${index}-"]`);
            const values = {};

            inputs.forEach(input => {
                if (input.type === 'file') {
                    if (input.files.length > 0) {
                        values[input.name] = input.files[0];
                    }
                    return;
                }

                if (input.value !== '') {
                    values[input.name] = input.value;
                }
            });

            return values;
        }

        function openResult(data) {
            const newTab = window.open();
            newTab.document.open();
            newTab.document.write(`<pre>${JSON.stringify(data, null, 2)}</pre>`);
            newTab.document.close();
        }

        function buildDashboardPayload(values) {
            return {
                bulan_mulai: values.bulan,
                bulan_akhir: values.bulan
            };
        }

        function requestApi(button) {
            const api = JSON.parse(button.dataset.api);
            const values = getInputValues(button.dataset.index);
            const headers = {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };

            let url = api.url;
            const options = {
                method: api.method,
                headers
            };

            if (api.method === 'GET') {
                const params = new URLSearchParams(values).toString();
                url = params ? `${url}?${params}` : url;
            }

            if (api.method === 'POST') {
                if (api.payload === 'form_data') {
                    const formData = new FormData();

                    Object.keys(values).forEach(key => {
                        formData.append(key, values[key]);
                    });

                    options.body = formData;
                } else {
                    headers['Content-Type'] = 'application/json';
                    options.body = JSON.stringify(api.payload === 'dashboard_month'
                        ? buildDashboardPayload(values)
                        : values);
                }
            }

            fetch(url, options)
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) {
                        throw data;
                    }
                    openResult(data);
                })
                .catch(error => openResult({
                    success: false,
                    message: 'Request gagal',
                    error
                }));
        }
    </script>
</body>

</html>
