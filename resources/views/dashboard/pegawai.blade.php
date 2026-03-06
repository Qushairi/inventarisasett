@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="h3 mb-1">Panel Pegawai</h2>
    <p class="text-muted mb-0">Dashboard inventaris aset untuk pegawai.</p>
</div>

<div class="row g-3">
    <div class="col-md-4"><div class="card shadow-sm"><div class="card-body"><div class="text-muted small">Total Aset</div><div class="h3 mb-0">{{ $stats['total_aset'] }}</div></div></div></div>
    <div class="col-md-4"><div class="card shadow-sm"><div class="card-body"><div class="text-muted small">Aset Tersedia</div><div class="h3 text-success mb-0">{{ $stats['aset_tersedia'] }}</div></div></div></div>
    <div class="col-md-4"><div class="card shadow-sm"><div class="card-body"><div class="text-muted small">Aset Dipinjam</div><div class="h3 text-warning mb-0">{{ $stats['aset_dipinjam'] }}</div></div></div></div>
</div>
@endsection
