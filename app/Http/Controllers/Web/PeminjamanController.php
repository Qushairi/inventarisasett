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

class PeminjamanController extends Controller
{
    public function __construct(private readonly PeminjamanService $service)
    {
    }

    public function index()
    {
        $peminjaman = PeminjamanAset::query()->with(['aset', 'pegawai', 'approver'])->latest()->paginate(10);
        $asetTersedia = Aset::query()->where('status', 'tersedia')->orderBy('nama')->get();
        $pegawai = User::query()->where('role', 'pegawai')->orderBy('name')->get();

        return view('peminjaman.index', compact('peminjaman', 'asetTersedia', 'pegawai'));
    }

    public function store(StorePeminjamanRequest $request)
    {
        $data = $request->validated();
        $data['pegawai_id'] = $data['pegawai_id'] ?? $request->user()?->id;

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
}
