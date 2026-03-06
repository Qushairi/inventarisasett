@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="h3 mb-0">Data Lokasi Aset</h2>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('lokasi-aset.store') }}" method="post" class="row g-3">
            @csrf
            <div class="col-md-6"><input name="nama" placeholder="Nama lokasi" class="form-control" required></div>
            <div class="col-md-6"><input name="kode" placeholder="Kode lokasi" class="form-control" required></div>
            <div class="col-md-6"><input name="alamat" placeholder="Alamat" class="form-control"></div>
            <div class="col-md-6"><input name="keterangan" placeholder="Keterangan" class="form-control"></div>
            <div class="col-12"><button class="btn btn-primary">Tambah Lokasi</button></div>
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
