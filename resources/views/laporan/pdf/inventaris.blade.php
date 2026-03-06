<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111827; }
        h1 { font-size: 18px; margin: 0 0 6px; }
        .meta { margin-bottom: 12px; color: #4b5563; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #d1d5db; padding: 6px; text-align: left; }
        th { background: #f3f4f6; }
        .summary { margin: 12px 0; }
        .summary span { display: inline-block; margin-right: 14px; }
    </style>
</head>
<body>
    <h1>Laporan Inventaris Aset</h1>
    <div class="meta">Dicetak: {{ $printedAt->format('d-m-Y H:i:s') }}</div>

    <div class="summary">
        <span>Total Aset: <strong>{{ $summary['total_aset'] }}</strong></span>
        <span>Aset Tersedia: <strong>{{ $summary['aset_tersedia'] }}</strong></span>
        <span>Total Peminjaman: <strong>{{ $summary['total_peminjaman'] }}</strong></span>
        <span>Total Pengembalian: <strong>{{ $summary['total_pengembalian'] }}</strong></span>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Aset</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($aset as $item)
                <tr>
                    <td>{{ $item->kode_aset }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kategori->nama ?? '-' }}</td>
                    <td>{{ $item->lokasi->nama ?? '-' }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->kondisi }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada data aset.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
