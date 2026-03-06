@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="h3 mb-0">Data Aset</h2>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('aset.store') }}" method="post" class="row g-3">
            @csrf
            <div class="col-md-4"><input name="kode_aset" placeholder="Kode aset" class="form-control" required></div>
            <div class="col-md-4"><input name="nama" placeholder="Nama aset" class="form-control" required></div>
            <div class="col-md-4">
                <select name="kategori_aset_id" class="form-select" required>
                    <option value="">Pilih kategori</option>
                    @foreach ($kategori as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="lokasi_aset_id" class="form-select" required>
                    <option value="">Pilih lokasi</option>
                    @foreach ($lokasi as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="kondisi" class="form-select" required>
                    <option value="baik">Baik</option>
                    <option value="rusak_ringan">Rusak Ringan</option>
                    <option value="rusak_berat">Rusak Berat</option>
                </select>
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="tersedia">Tersedia</option>
                    <option value="dipinjam">Dipinjam</option>
                    <option value="maintenance">Maintenance</option>
                </select>
            </div>
            <div class="col-md-4"><input type="date" name="tanggal_perolehan" class="form-control"></div>
            <div class="col-md-4"><input type="number" step="0.01" name="nilai_perolehan" placeholder="Nilai perolehan" class="form-control"></div>
            <div class="col-md-4"><input name="keterangan" placeholder="Keterangan" class="form-control"></div>
            <div class="col-12"><button class="btn btn-primary">Tambah Aset</button></div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Status</th>
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
                        <td>{{ $item->status }}</td>
                        <td>
                            <form action="{{ route('aset.destroy', $item) }}" method="post">
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

<div class="mt-3">{{ $aset->links() }}</div>
@endsection
