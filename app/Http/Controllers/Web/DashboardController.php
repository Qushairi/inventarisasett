<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use App\Models\PeminjamanAset;
use App\Models\PengembalianAset;

class DashboardController extends Controller
{
    public function admin()
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        $stats = $this->buildStats();

        return view('dashboard.admin', compact('stats'));
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
            'aset_tersedia' => Aset::query()->where('status', 'tersedia')->count(),
            'aset_dipinjam' => Aset::query()->where('status', 'dipinjam')->count(),
            'maintenance' => Aset::query()->where('status', 'maintenance')->count(),
            'peminjaman_menunggu' => PeminjamanAset::query()->where('status', 'menunggu')->count(),
            'pengembalian_menunggu' => PengembalianAset::query()->where('status', 'menunggu_verifikasi')->count(),
        ];

        return $stats;
    }
}
