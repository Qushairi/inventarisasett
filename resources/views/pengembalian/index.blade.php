@extends('layouts.app')

@section('page_title', 'Pengembalian Aset')
@section('page_subtitle', auth()->user()?->role === 'admin' ? 'Kelola proses pengembalian dan verifikasi' : 'Ajukan dan lihat status pengembalian aset')

@section('content')
@php($isAdmin = auth()->user()?->role === 'admin')
@php($isPegawai = auth()->user()?->role === 'pegawai')
@php
    $statusClasses = [
        'menunggu_verifikasi' => 'data-chip-info',
        'terverifikasi' => 'data-chip-success',
    ];
    $conditionClasses = [
        'baik' => 'data-chip-success',
        'rusak_ringan' => 'data-chip-warning',
        'rusak_berat' => 'data-chip-danger',
    ];
@endphp

<div class="data-page-toolbar">
    <div class="data-page-summary">
        <span class="data-page-count">
            <i class="bi bi-clipboard2-check-fill"></i>{{ $pengembalian->total() }} Pengembalian
        </span>
        <p class="data-page-summary-text">
            {{ $isAdmin ? 'Pantau dan verifikasi proses pengembalian aset dari pegawai.' : 'Riwayat pengajuan pengembalian aset yang pernah Anda kirimkan.' }}
        </p>
    </div>

    @if ($isPegawai)
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPengembalianModal">
            <i class="bi bi-plus-circle me-1"></i>Ajukan Pengembalian
        </button>
    @endif
</div>

@if ($isPegawai)
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
                            <label class="modal-field-label">Peminjaman Aktif</label>
                            <select name="peminjaman_aset_id" class="form-select" required>
                                <option value="">Pilih peminjaman aktif</option>
                                @foreach ($peminjamanAktif as $item)
                                    <option value="{{ $item->id }}" @selected(old('peminjaman_aset_id') == $item->id)>{{ $item->aset->kode_aset }} - {{ $item->aset->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="modal-field-label">Tanggal Kembali</label>
                            <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="modal-field-label">Kondisi Saat Kembali</label>
                            <select name="kondisi_saat_kembali" class="form-select" required>
                                <option value="baik" @selected(old('kondisi_saat_kembali', 'baik') === 'baik')>Baik</option>
                                <option value="rusak_ringan" @selected(old('kondisi_saat_kembali') === 'rusak_ringan')>Rusak Ringan</option>
                                <option value="rusak_berat" @selected(old('kondisi_saat_kembali') === 'rusak_berat')>Rusak Berat</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="modal-field-label">Catatan</label>
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
@endif

<div class="card shadow-sm data-table-card">
    <div class="table-responsive">
        <table class="table table-hover data-table data-table-lg mb-0">
            <thead class="table-light">
                <tr>
                    <th>Aset</th>
                    <th>Tanggal Kembali</th>
                    <th>Kondisi</th>
                    <th>Status</th>
                    <th>Berita Acara</th>
                    @if ($isAdmin)
                        <th class="text-end">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($pengembalian as $item)
                    @php($verifyModalId = 'verifyPengembalianModal-' . $item->id)
                    <tr>
                        <td>
                            <div class="data-table-title">{{ $item->peminjaman->aset->nama }}</div>
                            <div class="data-table-meta">{{ $item->peminjaman->aset->kode_aset }}</div>
                        </td>
                        <td>
                            <div class="data-table-title">{{ $item->tanggal_kembali?->format('d/m/Y') ?? '-' }}</div>
                            <div class="data-table-note">
                                {{ $item->verifier ? 'Diverifikasi ' . $item->verifier->name : 'Menunggu verifikasi admin' }}
                            </div>
                        </td>
                        <td>
                            <span class="data-chip {{ $conditionClasses[$item->kondisi_saat_kembali] ?? 'data-chip-neutral' }}">
                                {{ ucwords(str_replace('_', ' ', $item->kondisi_saat_kembali)) }}
                            </span>
                        </td>
                        <td>
                            <span class="data-chip {{ $statusClasses[$item->status] ?? 'data-chip-neutral' }}">
                                {{ ucwords(str_replace('_', ' ', $item->status)) }}
                            </span>
                            <div class="data-table-note">{{ $item->catatan ?: 'Tidak ada catatan tambahan.' }}</div>
                        </td>
                        <td>
                            <div class="data-table-plain">{{ $item->beritaAcara->nomor_ba ?? '-' }}</div>
                            <div class="data-table-note">
                                {{ $item->beritaAcara ? 'Berita acara sudah tersedia.' : 'Belum ada berita acara.' }}
                            </div>
                        </td>
                        @if ($isAdmin)
                            <td class="text-end">
                                <div class="data-table-actions">
                                    @if ($item->status !== 'terverifikasi')
                                        <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#{{ $verifyModalId }}">
                                            <i class="bi bi-patch-check me-1"></i>Verifikasi
                                        </button>
                                    @endif

                                    @if ($item->beritaAcara)
                                        <a href="{{ route('pengembalian.berita-acara.pdf', $item) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-download me-1"></i>BA PDF
                                        </a>
                                    @endif
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $isAdmin ? 6 : 5 }}" class="data-table-empty">
                            <i class="bi bi-clipboard-x"></i>
                            <div class="data-table-empty-title">Belum ada data pengembalian</div>
                            <p class="data-table-empty-text">Pengajuan pengembalian aset akan muncul di halaman ini setelah dikirim.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $pengembalian->links() }}</div>

@if ($isAdmin)
    @foreach ($pengembalian as $item)
        @php
            $verifyModalId = 'verifyPengembalianModal-' . $item->id;
            $isCurrentVerifyModal = old('_modal') === $verifyModalId;
        @endphp
        <div class="modal fade" id="{{ $verifyModalId }}" tabindex="-1" aria-labelledby="{{ $verifyModalId }}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="{{ $verifyModalId }}Label">Verifikasi Pengembalian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pengembalian.verify', $item) }}" method="post" class="row g-3">
                            @csrf
                            <input type="hidden" name="_modal" value="{{ $verifyModalId }}">
                            <div class="col-12">
                                <label class="modal-field-label">Aset</label>
                                <input value="{{ $item->peminjaman->aset->kode_aset }} - {{ $item->peminjaman->aset->nama }}" class="form-control" disabled>
                            </div>
                            <div class="col-12">
                                <label class="modal-field-label">Penandatangan</label>
                                <input
                                    name="ditandatangani_oleh"
                                    value="{{ $isCurrentVerifyModal ? old('ditandatangani_oleh') : '' }}"
                                    placeholder="Masukkan nama penandatangan"
                                    class="form-control"
                                    required
                                >
                            </div>
                            <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button class="btn btn-success">Verifikasi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const targetModal = @json(old('_modal'));
        if (!targetModal) return;
        const modalEl = document.getElementById(targetModal);
        if (!modalEl || typeof bootstrap === 'undefined') return;
        new bootstrap.Modal(modalEl).show();
    });
</script>
@endpush
