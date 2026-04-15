@extends('layouts.app')

@section('page_title', 'Peminjaman Aset')
@section('page_subtitle', auth()->user()?->role === 'admin' ? 'Kelola pengajuan dan persetujuan peminjaman' : 'Ajukan dan lihat data peminjaman aset')
<<<<<<< HEAD

@section('content')
@php($isAdmin = auth()->user()?->role === 'admin')
@php($isPegawai = auth()->user()?->role === 'pegawai')

@if ($isPegawai)
    <div class="d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPeminjamanModal">
            <i class="bi bi-plus-circle me-1"></i>Ajukan Peminjaman
        </button>
=======

@section('content')
@php($isAdmin = auth()->user()?->role === 'admin')
@php($isPegawai = auth()->user()?->role === 'pegawai')

<div class="d-flex justify-content-end mb-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPeminjamanModal">
        <i class="bi bi-plus-circle me-1"></i>Ajukan Peminjaman
    </button>
</div>

<div class="modal fade" id="tambahPeminjamanModal" tabindex="-1" aria-labelledby="tambahPeminjamanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPeminjamanModalLabel">Ajukan Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('peminjaman.store') }}" method="post" class="row g-3">
                    @csrf
                    <input type="hidden" name="_modal" value="tambahPeminjamanModal">
                    <div class="col-md-6">
                        <label class="form-label">Aset</label>
                        <select name="aset_id" class="form-select" required>
                            <option value="">Pilih aset tersedia</option>
                            @foreach ($asetTersedia as $aset)
                                <option value="{{ $aset->id }}" @selected(old('aset_id') == $aset->id)>{{ $aset->kode_aset }} - {{ $aset->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if ($isAdmin)
                        <div class="col-md-6">
                            <label class="form-label">Pegawai</label>
                            <select name="pegawai_id" class="form-select">
                                <option value="">Pilih pegawai</option>
                                @foreach ($pegawai as $item)
                                    <option value="{{ $item->id }}" @selected(old('pegawai_id') == $item->id)>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Rencana Kembali</label>
                        <input type="date" name="tanggal_rencana_kembali" value="{{ old('tanggal_rencana_kembali') }}" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <input name="keterangan" value="{{ old('keterangan') }}" placeholder="Keterangan" class="form-control">
                    </div>
                    <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
>>>>>>> 6b6d832d8360eb82d942c61e6349e16a5cb61b10
    </div>

    <div class="modal fade" id="tambahPeminjamanModal" tabindex="-1" aria-labelledby="tambahPeminjamanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPeminjamanModalLabel">Ajukan Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('peminjaman.store') }}" method="post" class="row g-3">
                        @csrf
                        <input type="hidden" name="_modal" value="tambahPeminjamanModal">
                        <div class="col-md-6">
                            <label class="form-label">Aset</label>
                            <select name="aset_id" class="form-select" required>
                                <option value="">Pilih aset tersedia</option>
                                @foreach ($asetTersedia as $aset)
                                    <option value="{{ $aset->id }}" @selected(old('aset_id') == $aset->id)>{{ $aset->kode_aset }} - {{ $aset->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rencana Kembali</label>
                            <input type="date" name="tanggal_rencana_kembali" value="{{ old('tanggal_rencana_kembali') }}" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <input name="keterangan" value="{{ old('keterangan') }}" placeholder="Keterangan" class="form-control">
                        </div>
                        <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Aset</th>
                    <th>Pegawai</th>
                    <th>Tgl Pinjam</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peminjaman as $item)
                    <tr>
                        <td>{{ $item->aset->nama }}</td>
                        <td>{{ $item->pegawai->name ?? '-' }}</td>
                        <td>{{ $item->tanggal_pinjam?->format('Y-m-d') }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            <div class="d-flex flex-wrap gap-2">
                                @if ($isPegawai && in_array($item->status, ['approved', 'dipinjam'], true))
                                    <a href="{{ route('peminjaman.surat.pdf', $item) }}" class="btn btn-sm btn-outline-primary">
                                        Download Surat
                                    </a>
                                @endif
                                @if ($isAdmin)
                                    <form action="{{ route('peminjaman.approve', $item) }}" method="post">
                                        @csrf
                                        <button class="btn btn-sm btn-success">Approve</button>
                                    </form>
                                    <form action="{{ route('peminjaman.reject', $item) }}" method="post" class="d-flex gap-2">
                                        @csrf
                                        <input name="alasan_penolakan" placeholder="Alasan" class="form-control form-control-sm">
                                        <button class="btn btn-sm btn-danger">Reject</button>
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

<div class="mt-3">{{ $peminjaman->links() }}</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const targetModal = @json(old('_modal'));
        if (targetModal !== 'tambahPeminjamanModal') return;
        const modalEl = document.getElementById(targetModal);
        if (!modalEl || typeof bootstrap === 'undefined') return;
        new bootstrap.Modal(modalEl).show();
    });
</script>
@endpush
