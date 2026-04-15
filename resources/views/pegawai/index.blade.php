@extends('layouts.app')

@section('page_title', 'Data Pegawai')
@section('page_subtitle', 'Kelola akun pegawai (dibuat oleh admin)')

@section('content')
<div class="d-flex justify-content-end mb-3">
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
                    <div class="col-md-4"><input name="name" value="{{ old('name') }}" placeholder="Nama pegawai" class="form-control" required></div>
                    <div class="col-md-4"><input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="form-control" required></div>
                    <div class="col-md-4"><input type="password" name="password" placeholder="Password (min. 8 karakter)" class="form-control" required></div>
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
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pegawai as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                            <div class="d-flex flex-wrap gap-2">
                                <form action="{{ route('pegawai.update', $item) }}" method="post" class="d-flex flex-wrap gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input name="name" value="{{ $item->name }}" class="form-control form-control-sm" style="max-width: 180px;" required>
                                    <input type="email" name="email" value="{{ $item->email }}" class="form-control form-control-sm" style="max-width: 220px;" required>
                                    <input type="password" name="password" placeholder="Password baru (opsional)" class="form-control form-control-sm" style="max-width: 220px;">
                                    <button class="btn btn-sm btn-warning">Update</button>
                                </form>

                                <form action="{{ route('pegawai.destroy', $item) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus akun pegawai ini?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-3">Belum ada data pegawai.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $pegawai->links() }}</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const targetModal = @json(old('_modal'));
        if (targetModal !== 'tambahPegawaiModal') return;
        const modalEl = document.getElementById(targetModal);
        if (!modalEl || typeof bootstrap === 'undefined') return;
        new bootstrap.Modal(modalEl).show();
    });
</script>
@endpush
