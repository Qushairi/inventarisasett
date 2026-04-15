@extends('layouts.app')

@section('page_title', 'Laporan Inventaris Aset')
@section('page_subtitle', 'Ringkasan data dan unduh laporan PDF')

@section('content')
<div class="mb-4 d-flex flex-wrap gap-2">
    <a href="{{ route('laporan.pdf.inventaris') }}" class="btn btn-outline-primary">Download PDF Inventaris</a>
    <a href="{{ route('laporan.pdf.peminjaman') }}" class="btn btn-outline-success">Download PDF Peminjaman</a>
    <a href="{{ route('laporan.pdf.pengembalian') }}" class="btn btn-outline-warning">Download PDF Pengembalian</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card shadow-sm"><div class="card-body"><div class="text-muted small">Total Aset</div><div class="h4 mb-0">{{ $summary['total_aset'] }}</div></div></div></div>
    <div class="col-md-3"><div class="card shadow-sm"><div class="card-body"><div class="text-muted small">Total Peminjaman</div><div class="h4 mb-0">{{ $summary['total_peminjaman'] }}</div></div></div></div>
    <div class="col-md-3"><div class="card shadow-sm"><div class="card-body"><div class="text-muted small">Total Pengembalian</div><div class="h4 mb-0">{{ $summary['total_pengembalian'] }}</div></div></div></div>
    <div class="col-md-3"><div class="card shadow-sm"><div class="card-body"><div class="text-muted small">Aset Tersedia</div><div class="h4 mb-0">{{ $summary['aset_tersedia'] }}</div></div></div></div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h3 class="h5 mb-3">Riwayat Peminjaman Terbaru</h3>
                <div class="table-responsive">
                    <table class="table table-sm table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Aset</th>
                                <th>Pegawai</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latestPeminjaman as $item)
                                <tr>
                                    <td>{{ $item->aset->nama }}</td>
                                    <td>{{ $item->pegawai->name ?? '-' }}</td>
                                    <td>{{ $item->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h3 class="h5 mb-3">Riwayat Pengembalian Terbaru</h3>
                <div class="table-responsive">
                    <table class="table table-sm table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Aset</th>
                                <th>Status</th>
                                <th>No. BA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latestPengembalian as $item)
                                <tr>
                                    <td>{{ $item->peminjaman->aset->nama }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>{{ $item->beritaAcara->nomor_ba ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
