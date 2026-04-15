@extends('layouts.app')

@section('page_title', 'Data Aset')
@section('page_subtitle', auth()->user()?->role === 'admin' ? 'Kelola data inventaris aset' : 'Lihat data inventaris aset')

@section('content')
@php($isAdmin = auth()->user()?->role === 'admin')

@if ($isAdmin)
    <div class="d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahAsetModal">
            <i class="bi bi-plus-circle me-1"></i>Tambah Aset
        </button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode Aset</th>
                    <th>Nama Aset</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Kondisi</th>
                    <th>Status</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($aset as $item)
                    <tr>
                        <td>{{ $item->kode_aset }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->kategori->nama }}</td>
                        <td>{{ $item->lokasi->nama }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $item->kondisi)) }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            @if ($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto {{ $item->nama }}" class="img-thumbnail" style="width: 64px; height: 64px; object-fit: cover;">
                            @else
                                <span class="text-muted small">Tidak ada</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('aset.show', $item) }}" class="btn btn-sm btn-info text-white">Detail</a>
                                @if ($isAdmin)
                                    <form action="{{ route('aset.destroy', $item) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $aset->links() }}</div>

@if ($isAdmin)
    <div class="modal fade" id="tambahAsetModal" tabindex="-1" aria-labelledby="tambahAsetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahAsetModalLabel">Tambah Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('aset.store') }}" method="post" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        <div class="col-md-4">
                            <label class="form-label">Kode Aset</label>
                            <input name="kode_aset" value="{{ old('kode_aset') }}" placeholder="Kode aset" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nama Aset</label>
                            <input name="nama" value="{{ old('nama') }}" placeholder="Nama aset" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Foto</label>
                            <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                            <small class="text-muted">Opsional, maksimal 2MB.</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kategori</label>
                            <select name="kategori_aset_id" class="form-select" required>
                                <option value="">Pilih kategori</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}" @selected(old('kategori_aset_id') == $item->id)>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Lokasi</label>
                            <select name="lokasi_aset_id" class="form-select" required>
                                <option value="">Pilih lokasi</option>
                                @foreach ($lokasi as $item)
                                    <option value="{{ $item->id }}" @selected(old('lokasi_aset_id') == $item->id)>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kondisi</label>
                            <select name="kondisi" class="form-select" required>
                                <option value="baik" @selected(old('kondisi', 'baik') === 'baik')>Baik</option>
                                <option value="rusak_ringan" @selected(old('kondisi') === 'rusak_ringan')>Rusak Ringan</option>
                                <option value="rusak_berat" @selected(old('kondisi') === 'rusak_berat')>Rusak Berat</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="tersedia" @selected(old('status', 'tersedia') === 'tersedia')>Tersedia</option>
                                <option value="dipinjam" @selected(old('status') === 'dipinjam')>Dipinjam</option>
                                <option value="maintenance" @selected(old('status') === 'maintenance')>Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Perolehan</label>
                            <input type="date" name="tanggal_perolehan" value="{{ old('tanggal_perolehan') }}" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nilai Perolehan</label>
                            <input type="number" step="0.01" name="nilai_perolehan" value="{{ old('nilai_perolehan') }}" placeholder="Nilai perolehan" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <input name="keterangan" value="{{ old('keterangan') }}" placeholder="Keterangan" class="form-control">
                        </div>
                        <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button class="btn btn-primary">Simpan Aset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

@if ($isAdmin)
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hasError = @json($errors->any());
        if (!hasError) return;
        const modalEl = document.getElementById('tambahAsetModal');
        if (!modalEl || typeof bootstrap === 'undefined') return;
        new bootstrap.Modal(modalEl).show();
    });
</script>
@endpush
@endif
