<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use App\Models\PeminjamanAset;
use App\Models\PengembalianAset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function peminjaman(Request $request): JsonResponse
    {
        $data = PeminjamanAset::query()
            ->with(['aset', 'pegawai'])
            ->when($request->date('start_date'), fn ($q, $startDate) => $q->whereDate('tanggal_pinjam', '>=', $startDate))
            ->when($request->date('end_date'), fn ($q, $endDate) => $q->whereDate('tanggal_pinjam', '<=', $endDate))
            ->latest()
            ->paginate(20);

        return response()->json($data);
    }

    public function pengembalian(Request $request): JsonResponse
    {
        $data = PengembalianAset::query()
            ->with(['peminjaman.aset', 'beritaAcara'])
            ->when($request->date('start_date'), fn ($q, $startDate) => $q->whereDate('tanggal_kembali', '>=', $startDate))
            ->when($request->date('end_date'), fn ($q, $endDate) => $q->whereDate('tanggal_kembali', '<=', $endDate))
            ->latest()
            ->paginate(20);

        return response()->json($data);
    }

    public function inventaris(): JsonResponse
    {
        $ringkasan = [
            'total_aset' => Aset::query()->count(),
            'tersedia' => Aset::query()->where('status', 'tersedia')->count(),
            'dipinjam' => Aset::query()->where('status', 'dipinjam')->count(),
            'maintenance' => Aset::query()->where('status', 'maintenance')->count(),
        ];

        return response()->json($ringkasan);
    }
}
