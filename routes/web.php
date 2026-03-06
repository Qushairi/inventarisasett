<?php

use App\Http\Controllers\Web\AsetController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\KategoriAsetController;
use App\Http\Controllers\Web\LaporanController;
use App\Http\Controllers\Web\LokasiAsetController;
use App\Http\Controllers\Web\PeminjamanController;
use App\Http\Controllers\Web\PengembalianController;
use App\Http\Controllers\Web\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::redirect('/', '/login');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return match (auth()->user()?->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'pegawai' => redirect()->route('pegawai.dashboard'),
            default => abort(403),
        };
    })->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/pegawai/dashboard', [DashboardController::class, 'pegawai'])->name('pegawai.dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/foto', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/aset', [AsetController::class, 'index'])->name('aset.index');
    Route::get('/aset/{aset}', [AsetController::class, 'show'])->name('aset.show');
    Route::post('/aset', [AsetController::class, 'store'])->name('aset.store');
    Route::put('/aset/{aset}', [AsetController::class, 'update'])->name('aset.update');
    Route::delete('/aset/{aset}', [AsetController::class, 'destroy'])->name('aset.destroy');

    Route::get('/kategori-aset', [KategoriAsetController::class, 'index'])->name('kategori-aset.index');
    Route::post('/kategori-aset', [KategoriAsetController::class, 'store'])->name('kategori-aset.store');
    Route::put('/kategori-aset/{kategoriAset}', [KategoriAsetController::class, 'update'])->name('kategori-aset.update');
    Route::delete('/kategori-aset/{kategoriAset}', [KategoriAsetController::class, 'destroy'])->name('kategori-aset.destroy');

    Route::get('/lokasi-aset', [LokasiAsetController::class, 'index'])->name('lokasi-aset.index');
    Route::post('/lokasi-aset', [LokasiAsetController::class, 'store'])->name('lokasi-aset.store');
    Route::put('/lokasi-aset/{lokasiAset}', [LokasiAsetController::class, 'update'])->name('lokasi-aset.update');
    Route::delete('/lokasi-aset/{lokasiAset}', [LokasiAsetController::class, 'destroy'])->name('lokasi-aset.destroy');

    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::post('/peminjaman/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('/peminjaman/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');

    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::post('/pengembalian', [PengembalianController::class, 'store'])->name('pengembalian.store');
    Route::post('/pengembalian/{pengembalian}/verify', [PengembalianController::class, 'verify'])->name('pengembalian.verify');
    Route::get('/pengembalian/{pengembalian}/berita-acara-pdf', [PengembalianController::class, 'beritaAcaraPdf'])->name('pengembalian.berita-acara.pdf');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf/inventaris', [LaporanController::class, 'inventarisPdf'])->name('laporan.pdf.inventaris');
    Route::get('/laporan/pdf/peminjaman', [LaporanController::class, 'peminjamanPdf'])->name('laporan.pdf.peminjaman');
    Route::get('/laporan/pdf/pengembalian', [LaporanController::class, 'pengembalianPdf'])->name('laporan.pdf.pengembalian');
});
