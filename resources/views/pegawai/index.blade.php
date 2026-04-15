@extends('layouts.app')

@section('page_title', 'Data Pegawai')
@section('page_subtitle', 'Kelola akun pegawai (dibuat oleh admin)')

@push('styles')
<style>
    .pegawai-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .pegawai-summary {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }

    .pegawai-badge-count {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        width: fit-content;
        padding: 0.45rem 0.85rem;
        border-radius: 999px;
        background: #edf4ff;
        color: #1f4eb4;
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.03em;
        text-transform: uppercase;
    }

    .pegawai-summary-text {
        color: #64748b;
        font-size: 0.95rem;
        margin: 0;
    }

    .pegawai-card {
        overflow: hidden;
    }

    .pegawai-table {
        min-width: 860px;
    }

    .pegawai-identity {
        display: flex;
        align-items: center;
        gap: 0.9rem;
    }

    .pegawai-avatar {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        overflow: hidden;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #eff5ff 0%, #dbeafe 100%);
        color: #1e3a8a;
        font-weight: 700;
        font-size: 1rem;
        box-shadow: inset 0 0 0 1px rgba(59, 130, 246, 0.12);
    }

    .pegawai-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .pegawai-name {
        font-size: 0.98rem;
        font-weight: 700;
        color: #102a43;
        margin-bottom: 0.2rem;
    }

    .pegawai-meta {
        color: #7b8794;
        font-size: 0.82rem;
    }

    .pegawai-role-chip {
        display: inline-flex;
        align-items: center;
        padding: 0.28rem 0.62rem;
        border-radius: 999px;
        background: #f8fafc;
        color: #334155;
        font-size: 0.73rem;
        font-weight: 700;
        border: 1px solid #e2e8f0;
        margin-top: 0.5rem;
    }

    .pegawai-email {
        font-weight: 600;
        color: #0f172a;
        word-break: break-word;
    }

    .pegawai-date {
        font-weight: 700;
        color: #102a43;
    }

    .pegawai-subtext {
        color: #7b8794;
        font-size: 0.82rem;
        margin-top: 0.18rem;
    }

    .pegawai-actions {
        display: flex;
        justify-content: flex-end;
        gap: 0.55rem;
        flex-wrap: wrap;
    }

    .pegawai-empty {
        padding: 3rem 1rem;
        text-align: center;
    }

    .pegawai-empty i {
        font-size: 1.9rem;
        color: #94a3b8;
        display: inline-block;
        margin-bottom: 0.65rem;
    }

    .pegawai-empty-title {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.35rem;
    }

    .pegawai-empty-text {
        color: #64748b;
        margin: 0;
    }

    .pegawai-modal-label {
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.45rem;
    }

    @media (max-width: 991.98px) {
        .pegawai-actions {
            justify-content: flex-start;
        }
    }
</style>
@endpush

@section('content')
<div class="pegawai-toolbar">
    <div class="pegawai-summary">
        <span class="pegawai-badge-count">
            <i class="bi bi-people-fill"></i>{{ $pegawai->total() }} Pegawai
        </span>
        <p class="pegawai-summary-text">Daftar akun pegawai yang dapat mengakses sistem inventaris aset.</p>
    </div>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPegawaiModal">
        <i class="bi bi-plus-circle me-1"></i>Tambah Pegawai
    </button>
</div>

<div class="modal fade" id="tambahPegawaiModal" tabindex="-1" aria-labelledby="tambahPegawaiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPegawaiModalLabel">Tambah Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pegawai.store') }}" method="post" class="row g-3">
                    @csrf
                    <input type="hidden" name="_modal" value="tambahPegawaiModal">
                    <div class="col-md-4">
                        <label class="pegawai-modal-label">Nama Pegawai</label>
                        <input name="name" value="{{ old('name') }}" placeholder="Nama pegawai" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="pegawai-modal-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="pegawai-modal-label">Password</label>
                        <input type="password" name="password" placeholder="Password (min. 8 karakter)" class="form-control" required>
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

<div class="card shadow-sm pegawai-card">
    <div class="table-responsive">
        <table class="table table-hover pegawai-table mb-0">
            <thead class="table-light">
                <tr>
                    <th>Pegawai</th>
                    <th>Email</th>
                    <th>Terdaftar</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pegawai as $item)
                    @php
                        $initials = collect(preg_split('/\s+/', trim($item->name ?? '')))
                            ->filter()
                            ->take(2)
                            ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
                            ->implode('');
                        $initials = $initials !== '' ? $initials : 'PG';
                        $editModalId = 'editPegawaiModal-' . $item->id;
                    @endphp
                    <tr>
                        <td>
                            <div class="pegawai-identity">
                                <div class="pegawai-avatar">
                                    @if ($item->foto)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($item->foto) }}" alt="{{ $item->name }}">
                                    @else
                                        <span>{{ $initials }}</span>
                                    @endif
                                </div>
                                <div>
                                    <div class="pegawai-name">{{ $item->name }}</div>
                                    <div class="pegawai-meta">ID Akun #{{ $item->id }}</div>
                                    <span class="pegawai-role-chip">Pegawai</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="pegawai-email">{{ $item->email }}</div>
                            <div class="pegawai-subtext">Digunakan sebagai akun login ke sistem.</div>
                        </td>
                        <td>
                            <div class="pegawai-date">{{ $item->created_at?->format('d/m/Y') ?? '-' }}</div>
                            <div class="pegawai-subtext">
                                {{ $item->created_at ? 'Pukul ' . $item->created_at->format('H:i') . ' WIB' : 'Waktu belum tersedia' }}
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="pegawai-actions">
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#{{ $editModalId }}">
                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                </button>
                                <form action="{{ route('pegawai.destroy', $item) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus akun pegawai ini?')">
                                        <i class="bi bi-trash me-1"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="pegawai-empty">
                            <i class="bi bi-people"></i>
                            <div class="pegawai-empty-title">Belum ada data pegawai</div>
                            <p class="pegawai-empty-text">Tambahkan akun pegawai baru agar dapat mengakses sistem inventaris.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $pegawai->links() }}</div>

@foreach ($pegawai as $item)
    @php
        $editModalId = 'editPegawaiModal-' . $item->id;
        $isCurrentEditModal = old('_modal') === $editModalId;
    @endphp
    <div class="modal fade" id="{{ $editModalId }}" tabindex="-1" aria-labelledby="{{ $editModalId }}Label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $editModalId }}Label">Edit Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pegawai.update', $item) }}" method="post" class="row g-3">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="_modal" value="{{ $editModalId }}">
                        <div class="col-md-6">
                            <label class="pegawai-modal-label">Nama Pegawai</label>
                            <input
                                name="name"
                                value="{{ $isCurrentEditModal ? old('name', $item->name) : $item->name }}"
                                class="form-control"
                                required
                            >
                        </div>
                        <div class="col-md-6">
                            <label class="pegawai-modal-label">Email</label>
                            <input
                                type="email"
                                name="email"
                                value="{{ $isCurrentEditModal ? old('email', $item->email) : $item->email }}"
                                class="form-control"
                                required
                            >
                        </div>
                        <div class="col-12">
                            <label class="pegawai-modal-label">Password Baru</label>
                            <input
                                type="password"
                                name="password"
                                placeholder="Kosongkan jika tidak ingin mengubah password"
                                class="form-control"
                            >
                        </div>
                        <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
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
