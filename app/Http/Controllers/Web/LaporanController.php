<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use App\Models\PeminjamanAset;
use App\Models\PengembalianAset;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $summary = $this->buildSummary();
        $latestPeminjaman = $this->buildPeminjamanQuery()->latest()->limit(10)->get();
        $latestPengembalian = $this->buildPengembalianQuery()->latest()->limit(10)->get();

        return view('laporan.index', compact('summary', 'latestPeminjaman', 'latestPengembalian'));
    }

    public function inventarisPdf(): Response
    {
        $summary = $this->buildSummary();
        $aset = Aset::query()->with(['kategori', 'lokasi'])->orderBy('nama')->get();

        $pdf = Pdf::loadView('laporan.pdf.inventaris', [
            'summary' => $summary,
            'aset' => $aset,
            'printedAt' => now(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-inventaris-' . now()->format('Ymd_His') . '.pdf');
    }

    public function peminjamanPdf(Request $request): Response
    {
        $peminjaman = $this->buildPeminjamanQuery()
            ->when($request->filled('start_date'), fn ($q) => $q->whereDate('tanggal_pinjam', '>=', $request->date('start_date')))
            ->when($request->filled('end_date'), fn ($q) => $q->whereDate('tanggal_pinjam', '<=', $request->date('end_date')))
            ->latest()
            ->get();

        $pdf = Pdf::loadView('laporan.pdf.peminjaman', [
            'peminjaman' => $peminjaman,
            'printedAt' => now(),
            'startDate' => $request->date('start_date'),
            'endDate' => $request->date('end_date'),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-peminjaman-' . now()->format('Ymd_His') . '.pdf');
    }

    public function pengembalianPdf(Request $request): Response
    {
        $pengembalian = $this->buildPengembalianQuery()
            ->when($request->filled('start_date'), fn ($q) => $q->whereDate('tanggal_kembali', '>=', $request->date('start_date')))
            ->when($request->filled('end_date'), fn ($q) => $q->whereDate('tanggal_kembali', '<=', $request->date('end_date')))
            ->latest()
            ->get();

        $pdf = Pdf::loadView('laporan.pdf.pengembalian', [
            'pengembalian' => $pengembalian,
            'printedAt' => now(),
            'startDate' => $request->date('start_date'),
            'endDate' => $request->date('end_date'),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-pengembalian-' . now()->format('Ymd_His') . '.pdf');
    }

    private function buildSummary(): array
    {
        return [
            'total_aset' => Aset::query()->count(),
            'total_peminjaman' => PeminjamanAset::query()->count(),
            'total_pengembalian' => PengembalianAset::query()->count(),
            'aset_tersedia' => Aset::query()->where('status', 'tersedia')->count(),
        ];
    }

    private function buildPeminjamanQuery(): Builder
    {
        return PeminjamanAset::query()->with(['aset', 'pegawai']);
    }

    private function buildPengembalianQuery(): Builder
    {
        return PengembalianAset::query()->with(['peminjaman.aset', 'beritaAcara']);
    }
}
