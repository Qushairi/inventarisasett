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
    </style>
</head>
<body>
    <h1>Laporan Pengembalian Aset</h1>
    <div class="meta">
        Dicetak: {{ $printedAt->format('d-m-Y H:i:s') }}
        @if ($startDate || $endDate)
            | Periode:
            {{ $startDate?->format('d-m-Y') ?? '-' }} s/d {{ $endDate?->format('d-m-Y') ?? '-' }}
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Aset</th>
                <th>Tanggal Kembali</th>
                <th>Kondisi</th>
                <th>Status</th>
                <th>No. Berita Acara</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengembalian as $item)
                <tr>
                    <td>{{ $item->peminjaman->aset->nama ?? '-' }}</td>
                    <td>{{ $item->tanggal_kembali?->format('d-m-Y') }}</td>
                    <td>{{ $item->kondisi_saat_kembali }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->beritaAcara->nomor_ba ?? '-' }}</td>
                    <td>{{ $item->catatan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada data pengembalian.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
