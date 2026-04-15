@extends('layouts.app')

@section('page_title', 'Profile')
@section('page_subtitle', 'Informasi akun pengguna')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="row g-4 mb-4">
            <div class="col-md-3 text-center">
                @if ($user->foto)
                    <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profile" class="img-thumbnail rounded-circle" style="width: 160px; height: 160px; object-fit: cover;">
                @else
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-secondary-subtle text-secondary" style="width: 160px; height: 160px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                            <path d="M14 13c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Z"/>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="col-md-9">
                <form action="{{ route('profile.photo.update') }}" method="post" enctype="multipart/form-data" class="row g-2 align-items-end">
                    @csrf
                    <div class="col-md-8">
                        <label class="form-label">Upload Foto Profile</label>
                        <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png,.webp" required>
                        <small class="text-muted">Format: JPG, PNG, WEBP. Maksimal 2MB.</small>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary w-100">Simpan Foto</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label text-muted">Nama</label>
                <div class="form-control bg-light">{{ $user->name }}</div>
            </div>
            <div class="col-md-6">
                <label class="form-label text-muted">Email</label>
                <div class="form-control bg-light">{{ $user->email }}</div>
            </div>
            <div class="col-md-6">
                <label class="form-label text-muted">Role</label>
                <div class="form-control bg-light text-uppercase">{{ $user->role }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
