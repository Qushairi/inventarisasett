@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="h3 mb-1">Panel Admin</h2>
    <p class="text-muted mb-0">Dashboard monitoring inventaris aset untuk administrator.</p>
</div>

<div class="row g-3">
    <div class="col-md-4"><div class="card shadow-sm"><div class="card-body"><div class="text-muted small">Total Aset</div><div class="h3 mb-0">{{ $stats['total_aset'] }}</div></div></div></div>
    <div class="col-md-4"><div class="card shadow-sm"><div class="card-body"><div class="text-muted small">Aset Tersedia</div><div class="h3 text-success mb-0">{{ $stats['aset_tersedia'] }}</div></div></div></div>
    <div class="col-md-4"><div class="card shadow-sm"><div class="card-body"><div class="text-muted small">Aset Dipinjam</div><div class="h3 text-warning mb-0">{{ $stats['aset_dipinjam'] }}</div></div></div></div>
    <div class="col-md-4"><div class="card shadow-sm"><div class="card-body"><div class="text-muted small">Maintenance</div><div class="h3 text-danger mb-0">{{ $stats['maintenance'] }}</div></div></div></div>
    <div class="col-md-4"><div class="card shadow-sm"><div class="card-body"><div class="text-muted small">Menunggu Persetujuan</div><div class="h3 mb-0">{{ $stats['peminjaman_menunggu'] }}</div></div></div></div>
    <div class="col-md-4"><div class="card shadow-sm"><div class="card-body"><div class="text-muted small">Menunggu Verifikasi Kembali</div><div class="h3 mb-0">{{ $stats['pengembalian_menunggu'] }}</div></div></div></div>
</div>
@endsection
