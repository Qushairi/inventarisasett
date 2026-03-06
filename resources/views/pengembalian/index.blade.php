@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="h3 mb-0">Pengembalian Aset</h2>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('pengembalian.store') }}" method="post" class="row g-3">
            @csrf
            <div class="col-md-6">
                <select name="peminjaman_aset_id" class="form-select" required>
                    <option value="">Pilih peminjaman aktif</option>
                    @foreach ($peminjamanAktif as $item)
                        <option value="{{ $item->id }}">{{ $item->aset->kode_aset }} - {{ $item->aset->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6"><input type="date" name="tanggal_kembali" class="form-control" required></div>
            <div class="col-md-6">
                <select name="kondisi_saat_kembali" class="form-select" required>
                    <option value="baik">Baik</option>
                    <option value="rusak_ringan">Rusak Ringan</option>
                    <option value="rusak_berat">Rusak Berat</option>
                </select>
            </div>
            <div class="col-md-6"><input name="catatan" placeholder="Catatan" class="form-control"></div>
            <div class="col-12"><button class="btn btn-primary">Ajukan Pengembalian</button></div>
        </form>
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengembalian as $item)
                    <tr>
                        <td>{{ $item->peminjaman->aset->nama }}</td>
                        <td>{{ $item->tanggal_kembali?->format('Y-m-d') }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->beritaAcara->nomor_ba ?? '-' }}</td>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $pengembalian->links() }}</div>
@endsection
