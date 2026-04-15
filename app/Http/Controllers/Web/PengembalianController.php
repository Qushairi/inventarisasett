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
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PengembalianController extends Controller
{
    public function __construct(private readonly PengembalianService $service)
    {
    }

    public function index()
    {
        $user = auth()->user();
        $isAdmin = $user?->role === 'admin';

        $pengembalian = PengembalianAset::query()
            ->with(['peminjaman.aset', 'beritaAcara', 'verifier'])
            ->when(! $isAdmin, fn ($query) => $query->whereHas('peminjaman', fn ($q) => $q->where('pegawai_id', $user?->id)))
            ->latest()
            ->paginate(10);

        $peminjamanAktif = PeminjamanAset::query()
            ->with('aset')
            ->where('status', 'dipinjam')
            ->whereDoesntHave('pengembalian')
            ->when(! $isAdmin, fn ($query) => $query->where('pegawai_id', $user?->id))
            ->latest()
            ->get();

        return view('pengembalian.index', compact('pengembalian', 'peminjamanAktif'));
    }

    public function store(StorePengembalianRequest $request)
    {
        $payload = $request->validated();
        $user = $request->user();

        if ($user?->role === 'pegawai') {
            $request->validate([
                'peminjaman_aset_id' => [
                    'required',
                    Rule::exists('peminjaman_aset', 'id')
                        ->where('pegawai_id', $user->id)
                        ->where('status', 'dipinjam'),
                ],
            ]);
        }

        $this->service->create($payload);

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
        if (auth()->user()?->role === 'pegawai') {
            abort_unless((int) $pengembalian->peminjaman?->pegawai_id === (int) auth()->id(), 403);
        }

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
