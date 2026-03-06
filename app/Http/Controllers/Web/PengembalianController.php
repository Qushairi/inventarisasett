<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePengembalianRequest;
use App\Http\Requests\VerifyPengembalianRequest;
use App\Models\PeminjamanAset;
use App\Models\PengembalianAset;
use App\Services\PengembalianService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PengembalianController extends Controller
{
    public function __construct(private readonly PengembalianService $service)
    {
    }

    public function index()
    {
        $pengembalian = PengembalianAset::query()->with(['peminjaman.aset', 'beritaAcara', 'verifier'])->latest()->paginate(10);
        $peminjamanAktif = PeminjamanAset::query()
            ->with('aset')
            ->where('status', 'dipinjam')
            ->whereDoesntHave('pengembalian')
            ->latest()
            ->get();

        return view('pengembalian.index', compact('pengembalian', 'peminjamanAktif'));
    }

    public function store(StorePengembalianRequest $request)
    {
        $this->service->create($request->validated());

        return back()->with('success', 'Pengembalian berhasil diajukan.');
    }

    public function verify(VerifyPengembalianRequest $request, PengembalianAset $pengembalian)
    {
        $this->service->verify(
            $pengembalian,
            $request->validated('diverifikasi_by') ?? $request->user()?->id,
            $request->validated('ditandatangani_oleh')
        );

        return back()->with('success', 'Pengembalian berhasil diverifikasi.');
    }

    public function beritaAcaraPdf(PengembalianAset $pengembalian): Response
    {
        $pengembalian->load([
            'peminjaman.aset.kategori',
            'peminjaman.pegawai',
            'beritaAcara',
            'verifier',
        ]);

        if (! $pengembalian->beritaAcara) {
            throw ValidationException::withMessages([
                'pengembalian' => 'Berita acara belum tersedia. Verifikasi pengembalian terlebih dahulu.',
            ]);
        }

        $pdf = Pdf::loadView('pengembalian.pdf.berita-acara', [
            'pengembalian' => $pengembalian,
            'beritaAcara' => $pengembalian->beritaAcara,
            'aset' => $pengembalian->peminjaman->aset,
            'pegawai' => $pengembalian->peminjaman->pegawai,
            'verifier' => $pengembalian->verifier,
            'printedAt' => now(),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('berita-acara-' . $pengembalian->beritaAcara->nomor_ba . '.pdf');
    }
}
