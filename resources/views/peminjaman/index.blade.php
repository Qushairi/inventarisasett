@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="h3 mb-0">Peminjaman Aset</h2>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('peminjaman.store') }}" method="post" class="row g-3">
            @csrf
            <div class="col-md-6">
                <select name="aset_id" class="form-select" required>
                    <option value="">Pilih aset tersedia</option>
                    @foreach ($asetTersedia as $aset)
                        <option value="{{ $aset->id }}">{{ $aset->kode_aset }} - {{ $aset->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <select name="pegawai_id" class="form-select">
                    <option value="">Pilih pegawai</option>
                    @foreach ($pegawai as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6"><input type="date" name="tanggal_pinjam" class="form-control" required></div>
            <div class="col-md-6"><input type="date" name="tanggal_rencana_kembali" class="form-control"></div>
            <div class="col-12"><input name="keterangan" placeholder="Keterangan" class="form-control"></div>
            <div class="col-12"><button class="btn btn-primary">Ajukan Peminjaman</button></div>
        </form>
    </div>
</div>

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
                                <form action="{{ route('peminjaman.approve', $item) }}" method="post">
                                    @csrf
                                    <button class="btn btn-sm btn-success">Approve</button>
                                </form>
                                <form action="{{ route('peminjaman.reject', $item) }}" method="post" class="d-flex gap-2">
                                    @csrf
                                    <input name="alasan_penolakan" placeholder="Alasan" class="form-control form-control-sm">
                                    <button class="btn btn-sm btn-danger">Reject</button>
                                </form>
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
