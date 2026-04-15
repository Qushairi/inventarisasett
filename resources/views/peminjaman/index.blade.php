@extends('layouts.app')

@section('page_title', 'Peminjaman Aset')
@section('page_subtitle', auth()->user()?->role === 'admin' ? 'Kelola pengajuan dan persetujuan peminjaman' : 'Ajukan dan lihat data peminjaman aset')

@section('content')
@php($isAdmin = auth()->user()?->role === 'admin')
@php($isPegawai = auth()->user()?->role === 'pegawai')
@php
    $statusClasses = [
        'menunggu' => 'data-chip-info',
        'disetujui' => 'data-chip-primary',
        'approved' => 'data-chip-primary',
        'ditolak' => 'data-chip-danger',
        'dipinjam' => 'data-chip-warning',
        'selesai' => 'data-chip-success',
    ];
@endphp

<div class="data-page-toolbar">
    <div class="data-page-summary">
        <span class="data-page-count">
            <i class="bi bi-journal-text"></i>{{ $peminjaman->total() }} Peminjaman
        </span>
        <p class="data-page-summary-text">
            {{ $isAdmin ? 'Pantau, setujui, atau tolak permintaan peminjaman aset dari pegawai.' : 'Riwayat pengajuan peminjaman aset yang pernah Anda buat.' }}
        </p>
    </div>

    @if ($isPegawai)
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPeminjamanModal">
            <i class="bi bi-plus-circle me-1"></i>Ajukan Peminjaman
        </button>
    @endif
</div>

@if ($isPegawai)
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
                            <label class="modal-field-label">Aset</label>
                            <select name="aset_id" class="form-select" required>
                                <option value="">Pilih aset tersedia</option>
                                @foreach ($asetTersedia as $aset)
                                    <option value="{{ $aset->id }}" @selected(old('aset_id') == $aset->id)>{{ $aset->kode_aset }} - {{ $aset->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="modal-field-label">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="modal-field-label">Rencana Kembali</label>
                            <input type="date" name="tanggal_rencana_kembali" value="{{ old('tanggal_rencana_kembali') }}" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="modal-field-label">Keterangan</label>
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

<div class="card shadow-sm data-table-card">
    <div class="table-responsive">
        <table class="table table-hover data-table data-table-lg mb-0">
            <thead class="table-light">
                <tr>
                    <th>Aset</th>
                    <th>Pegawai</th>
                    <th>Tgl Pinjam</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjaman as $item)
                    @php($rejectModalId = 'rejectPeminjamanModal-' . $item->id)
                    <tr>
                        <td>
                            <div class="data-table-title">{{ $item->aset->nama }}</div>
                            <div class="data-table-meta">{{ $item->aset->kode_aset }}</div>
                        </td>
                        <td>
                            <div class="data-table-plain">{{ $item->pegawai->name ?? '-' }}</div>
                            <div class="data-table-note">{{ $item->pegawai->email ?? 'Pegawai belum ditentukan.' }}</div>
                        </td>
                        <td>
                            <div class="data-table-title">{{ $item->tanggal_pinjam?->format('d/m/Y') ?? '-' }}</div>
                            <div class="data-table-note">
                                {{ $item->tanggal_rencana_kembali ? 'Rencana kembali ' . $item->tanggal_rencana_kembali->format('d/m/Y') : 'Belum ada rencana kembali' }}
                            </div>
                        </td>
                        <td>
                            <span class="data-chip {{ $statusClasses[$item->status] ?? 'data-chip-neutral' }}">
                                {{ ucwords(str_replace('_', ' ', $item->status)) }}
                            </span>
                            <div class="data-table-note">
                                @if ($item->status === 'ditolak' && $item->alasan_penolakan)
                                    {{ $item->alasan_penolakan }}
                                @elseif ($item->approver)
                                    Diproses oleh {{ $item->approver->name }}
                                @else
                                    Menunggu tindak lanjut.
                                @endif
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="data-table-actions">
                                @if ($isPegawai && in_array($item->status, ['approved', 'dipinjam'], true))
                                    <a href="{{ route('peminjaman.surat.pdf', $item) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download me-1"></i>Surat
                                    </a>
                                @endif
                                @if ($isAdmin)
                                    <form action="{{ route('peminjaman.approve', $item) }}" method="post">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-check-circle me-1"></i>Approve
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#{{ $rejectModalId }}">
                                        <i class="bi bi-x-circle me-1"></i>Reject
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="data-table-empty">
                            <i class="bi bi-journal-x"></i>
                            <div class="data-table-empty-title">Belum ada data peminjaman</div>
                            <p class="data-table-empty-text">Pengajuan peminjaman aset akan muncul di halaman ini setelah dibuat.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $peminjaman->links() }}</div>

@if ($isAdmin)
    @foreach ($peminjaman as $item)
        @php
            $rejectModalId = 'rejectPeminjamanModal-' . $item->id;
            $isCurrentRejectModal = old('_modal') === $rejectModalId;
        @endphp
        <div class="modal fade" id="{{ $rejectModalId }}" tabindex="-1" aria-labelledby="{{ $rejectModalId }}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="{{ $rejectModalId }}Label">Tolak Peminjaman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('peminjaman.reject', $item) }}" method="post" class="row g-3">
                            @csrf
                            <input type="hidden" name="_modal" value="{{ $rejectModalId }}">
                            <div class="col-12">
                                <label class="modal-field-label">Aset</label>
                                <input value="{{ $item->aset->kode_aset }} - {{ $item->aset->nama }}" class="form-control" disabled>
                            </div>
                            <div class="col-12">
                                <label class="modal-field-label">Alasan Penolakan</label>
                                <input
                                    name="alasan_penolakan"
                                    value="{{ $isCurrentRejectModal ? old('alasan_penolakan') : '' }}"
                                    placeholder="Masukkan alasan penolakan"
                                    class="form-control"
                                    required
                                >
                            </div>
                            <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button class="btn btn-danger">Tolak Peminjaman</button>
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
