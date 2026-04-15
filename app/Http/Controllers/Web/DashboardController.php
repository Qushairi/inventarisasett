<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use App\Models\PeminjamanAset;
use App\Models\PengembalianAset;
use App\Models\User;

class DashboardController extends Controller
{
    public function admin()
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        $stats = $this->buildStats();
        $latestAssets = Aset::query()
            ->with(['kategori', 'lokasi'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact('stats', 'latestAssets'));
    }

    public function pegawai()
    {
        abort_unless(auth()->user()?->role === 'pegawai', 403);

        $stats = $this->buildStats();

        return view('dashboard.pegawai', compact('stats'));
    }

    private function buildStats(): array
    {
        $stats = [
            'total_aset' => Aset::query()->count(),
            'total_pegawai' => User::query()->where('role', 'pegawai')->count(),
            'aset_tersedia' => Aset::query()->where('status', 'tersedia')->count(),
            'aset_dipinjam' => Aset::query()->where('status', 'dipinjam')->count(),
            'maintenance' => Aset::query()->where('status', 'maintenance')->count(),
            'kondisi_baik' => Aset::query()->where('kondisi', 'baik')->count(),
            'kondisi_rusak_ringan' => Aset::query()->where('kondisi', 'rusak_ringan')->count(),
            'kondisi_rusak_berat' => Aset::query()->where('kondisi', 'rusak_berat')->count(),
            'peminjaman_menunggu' => PeminjamanAset::query()->where('status', 'menunggu')->count(),
            'pengembalian_menunggu' => PengembalianAset::query()->where('status', 'menunggu_verifikasi')->count(),
        ];

        return $stats;
    }
}
