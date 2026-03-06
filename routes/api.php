<?php

use App\Http\Controllers\Api\AsetController;
use App\Http\Controllers\Api\KategoriAsetController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\LokasiAsetController;
use App\Http\Controllers\Api\PeminjamanController;
use App\Http\Controllers\Api\PengembalianController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::apiResource('aset', AsetController::class);
    Route::apiResource('kategori-aset', KategoriAsetController::class)->parameters(['kategori-aset' => 'kategoriAset']);
    Route::apiResource('lokasi-aset', LokasiAsetController::class)->parameters(['lokasi-aset' => 'lokasiAset']);

    Route::get('peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::post('peminjaman/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('peminjaman/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');

    Route::get('pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::post('pengembalian', [PengembalianController::class, 'store'])->name('pengembalian.store');
    Route::post('pengembalian/{pengembalian}/verify', [PengembalianController::class, 'verify'])->name('pengembalian.verify');

    Route::get('laporan/peminjaman', [LaporanController::class, 'peminjaman'])->name('laporan.peminjaman');
    Route::get('laporan/pengembalian', [LaporanController::class, 'pengembalian'])->name('laporan.pengembalian');
    Route::get('laporan/inventaris', [LaporanController::class, 'inventaris'])->name('laporan.inventaris');
});
