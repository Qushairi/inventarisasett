@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0">Detail Aset</h2>
    <a href="{{ route('aset.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-4">
                @if ($aset->foto)
                    <img src="{{ asset('storage/' . $aset->foto) }}" alt="Foto {{ $aset->nama }}" class="img-fluid rounded border" style="max-height: 420px; width: 100%; object-fit: cover;">
                @else
                    <div class="d-flex align-items-center justify-content-center border rounded bg-light text-muted" style="min-height: 280px;">
                        Tidak ada foto aset
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Kode Aset</label>
                        <div class="form-control bg-light">{{ $aset->kode_aset }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Nama Aset</label>
                        <div class="form-control bg-light">{{ $aset->nama }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Kategori</label>
                        <div class="form-control bg-light">{{ $aset->kategori->nama }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Lokasi</label>
                        <div class="form-control bg-light">{{ $aset->lokasi->nama }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Kondisi</label>
                        <div class="form-control bg-light">{{ str_replace('_', ' ', $aset->kondisi) }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Status</label>
                        <div class="form-control bg-light">{{ $aset->status }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Tanggal Perolehan</label>
                        <div class="form-control bg-light">{{ optional($aset->tanggal_perolehan)->format('d-m-Y') ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Nilai Perolehan</label>
                        <div class="form-control bg-light">{{ $aset->nilai_perolehan ? number_format((float) $aset->nilai_perolehan, 2, ',', '.') : '-' }}</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-muted">Keterangan</label>
                        <div class="form-control bg-light">{{ $aset->keterangan ?: '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
