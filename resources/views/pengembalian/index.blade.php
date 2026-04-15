@extends('layouts.app')

@section('page_title', 'Pengembalian Aset')
@section('page_subtitle', auth()->user()?->role === 'admin' ? 'Kelola proses pengembalian dan verifikasi' : 'Ajukan dan lihat status pengembalian aset')

@section('content')
@php($isAdmin = auth()->user()?->role === 'admin')

<div class="d-flex justify-content-end mb-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPengembalianModal">
        <i class="bi bi-plus-circle me-1"></i>Ajukan Pengembalian
    </button>
</div>

<div class="modal fade" id="tambahPengembalianModal" tabindex="-1" aria-labelledby="tambahPengembalianModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPengembalianModalLabel">Ajukan Pengembalian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pengembalian.store') }}" method="post" class="row g-3">
                    @csrf
                    <input type="hidden" name="_modal" value="tambahPengembalianModal">
                    <div class="col-md-6">
                        <label class="form-label">Peminjaman Aktif</label>
                        <select name="peminjaman_aset_id" class="form-select" required>
                            <option value="">Pilih peminjaman aktif</option>
                            @foreach ($peminjamanAktif as $item)
                                <option value="{{ $item->id }}" @selected(old('peminjaman_aset_id') == $item->id)>{{ $item->aset->kode_aset }} - {{ $item->aset->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kondisi Saat Kembali</label>
                        <select name="kondisi_saat_kembali" class="form-select" required>
                            <option value="baik" @selected(old('kondisi_saat_kembali', 'baik') === 'baik')>Baik</option>
                            <option value="rusak_ringan" @selected(old('kondisi_saat_kembali') === 'rusak_ringan')>Rusak Ringan</option>
                            <option value="rusak_berat" @selected(old('kondisi_saat_kembali') === 'rusak_berat')>Rusak Berat</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Catatan</label>
                        <input name="catatan" value="{{ old('catatan') }}" placeholder="Catatan" class="form-control">
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

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Aset</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Berita Acara</th>
                    @if ($isAdmin)
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($pengembalian as $item)
                    <tr>
                        <td>{{ $item->peminjaman->aset->nama }}</td>
                        <td>{{ $item->tanggal_kembali?->format('Y-m-d') }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->beritaAcara->nomor_ba ?? '-' }}</td>
                        @if ($isAdmin)
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    @if ($item->status !== 'terverifikasi')
                                        <form action="{{ route('pengembalian.verify', $item) }}" method="post" class="d-flex gap-2">
                                            @csrf
                                            <input name="ditandatangani_oleh" placeholder="Penandatangan" class="form-control form-control-sm">
                                            <button class="btn btn-sm btn-success">Verifikasi</button>
                                        </form>
                                    @endif

                                    @if ($item->beritaAcara)
                                        <a href="{{ route('pengembalian.berita-acara.pdf', $item) }}" class="btn btn-sm btn-outline-primary">
                                            Download BA PDF
                                        </a>
                                    @endif
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $pengembalian->links() }}</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const targetModal = @json(old('_modal'));
        if (targetModal !== 'tambahPengembalianModal') return;
        const modalEl = document.getElementById(targetModal);
        if (!modalEl || typeof bootstrap === 'undefined') return;
        new bootstrap.Modal(modalEl).show();
    });
</script>
@endpush
