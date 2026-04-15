@extends('layouts.app')

@section('page_title', 'Data Lokasi Aset')
@section('page_subtitle', 'Kelola penempatan lokasi inventaris')

@section('content')
<div class="d-flex justify-content-end mb-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahLokasiModal">
        <i class="bi bi-plus-circle me-1"></i>Tambah Lokasi
    </button>
</div>

<div class="modal fade" id="tambahLokasiModal" tabindex="-1" aria-labelledby="tambahLokasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahLokasiModalLabel">Tambah Lokasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('lokasi-aset.store') }}" method="post" class="row g-3">
                    @csrf
                    <input type="hidden" name="_modal" value="tambahLokasiModal">
                    <div class="col-md-6"><input name="nama" value="{{ old('nama') }}" placeholder="Nama lokasi" class="form-control" required></div>
                    <div class="col-md-6"><input name="kode" value="{{ old('kode') }}" placeholder="Kode lokasi" class="form-control" required></div>
                    <div class="col-md-6"><input name="alamat" value="{{ old('alamat') }}" placeholder="Alamat" class="form-control"></div>
                    <div class="col-md-6"><input name="keterangan" value="{{ old('keterangan') }}" placeholder="Keterangan" class="form-control"></div>
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
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lokasi as $item)
                    <tr>
                        <td>{{ $item->kode }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td>
                            <form action="{{ route('lokasi-aset.destroy', $item) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $lokasi->links() }}</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const targetModal = @json(old('_modal'));
        if (targetModal !== 'tambahLokasiModal') return;
        const modalEl = document.getElementById(targetModal);
        if (!modalEl || typeof bootstrap === 'undefined') return;
        new bootstrap.Modal(modalEl).show();
    });
</script>
@endpush
