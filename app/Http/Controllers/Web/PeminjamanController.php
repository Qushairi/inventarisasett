<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApprovePeminjamanRequest;
use App\Http\Requests\RejectPeminjamanRequest;
use App\Http\Requests\StorePeminjamanRequest;
use App\Models\Aset;
use App\Models\PeminjamanAset;
use App\Models\User;
use App\Services\PeminjamanService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PeminjamanController extends Controller
{
    public function __construct(private readonly PeminjamanService $service)
    {
    }

    public function index()
    {
        $user = auth()->user();
        $isAdmin = $user?->role === 'admin';

        $peminjaman = PeminjamanAset::query()
            ->with(['aset', 'pegawai', 'approver'])
            ->when(! $isAdmin, fn ($query) => $query->where('pegawai_id', $user?->id))
            ->latest()
            ->paginate(10);

        $asetTersedia = Aset::query()->where('status', 'tersedia')->orderBy('nama')->get();
        $pegawai = $isAdmin
            ? User::query()->where('role', 'pegawai')->orderBy('name')->get()
            : collect();

        return view('peminjaman.index', compact('peminjaman', 'asetTersedia', 'pegawai'));
    }

    public function store(StorePeminjamanRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();

        if ($user?->role === 'pegawai') {
            $data['pegawai_id'] = $user->id;
        } else {
            $data['pegawai_id'] = $data['pegawai_id'] ?? $user?->id;
        }

        $this->service->create($data);

        return back()->with('success', 'Pengajuan peminjaman berhasil disimpan.');
    }

    public function approve(ApprovePeminjamanRequest $request, PeminjamanAset $peminjaman)
    {
        $this->service->approve($peminjaman, $request->validated('approved_by') ?? $request->user()?->id);

        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function reject(RejectPeminjamanRequest $request, PeminjamanAset $peminjaman)
    {
        $this->service->reject(
            $peminjaman,
            $request->validated('alasan_penolakan'),
            $request->validated('approved_by') ?? $request->user()?->id
        );

        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    public function suratPdf(PeminjamanAset $peminjaman): Response
    {
        if (auth()->user()?->role === 'pegawai') {
            abort_unless((int) $peminjaman->pegawai_id === (int) auth()->id(), 403);
        }

        $peminjaman->load(['aset.kategori', 'pegawai', 'approver']);

        if (! in_array($peminjaman->status, ['approved', 'dipinjam'], true)) {
            throw ValidationException::withMessages([
                'peminjaman' => 'Surat peminjaman hanya tersedia untuk peminjaman yang sudah disetujui.',
            ]);
        }

        $pdf = Pdf::loadView('peminjaman.pdf.surat-peminjaman', [
            'peminjaman' => $peminjaman,
            'aset' => $peminjaman->aset,
            'pegawai' => $peminjaman->pegawai,
            'approver' => $peminjaman->approver,
            'printedAt' => now(),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('surat-peminjaman-aset-' . $peminjaman->id . '.pdf');
    }
}
