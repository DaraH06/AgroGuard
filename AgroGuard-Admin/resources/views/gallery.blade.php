<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Gallery Upload — AgroGuard</title>
    <style>
        body { font-family: monospace; background: #111; color: #ccc; padding: 24px; }
        h2   { color: #7ec8a0; margin-bottom: 4px; }
        p    { color: #666; font-size: 13px; margin-bottom: 24px; }
        pre  { background: #1a1a1a; border: 1px solid #333; border-radius: 6px;
               padding: 16px; white-space: pre-wrap; word-break: break-all;
               font-size: 13px; line-height: 1.6; margin-bottom: 16px; }
    </style>
</head>
<body>
    <h2>AgroGuard — Raw Upload Data</h2>
    <p>Collection: gambar_flutter &bull; {{ count($uploads) }} dokumen</p>

    @forelse($uploads as $item)
        <pre>{{ json_encode($item->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</pre>
    @empty
        <pre>// Belum ada data. Upload foto dari Flutter terlebih dahulu.</pre>
    @endforelse
</body>
</html>
