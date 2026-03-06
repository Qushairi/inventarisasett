<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApprovePeminjamanRequest;
use App\Http\Requests\RejectPeminjamanRequest;
use App\Http\Requests\StorePeminjamanRequest;
use App\Models\PeminjamanAset;
use App\Services\PeminjamanService;
use Illuminate\Http\JsonResponse;

class PeminjamanController extends Controller
{
    public function __construct(private readonly PeminjamanService $service)
    {
    }

    public function index(): JsonResponse
    {
        $data = PeminjamanAset::query()
            ->with(['aset', 'pegawai', 'approver'])
            ->latest()
            ->paginate(10);

        return response()->json($data);
    }

    public function store(StorePeminjamanRequest $request): JsonResponse
    {
        $payload = $request->validated();

        if (! isset($payload['pegawai_id']) && $request->user()) {
            $payload['pegawai_id'] = $request->user()->id;
        }

        $peminjaman = $this->service->create($payload);

        return response()->json($peminjaman->load(['aset', 'pegawai']), 201);
    }

    public function approve(ApprovePeminjamanRequest $request, PeminjamanAset $peminjaman): JsonResponse
    {
        $approvedBy = $request->validated('approved_by') ?? $request->user()?->id;
        $updated = $this->service->approve($peminjaman, $approvedBy);

        return response()->json($updated);
    }

    public function reject(RejectPeminjamanRequest $request, PeminjamanAset $peminjaman): JsonResponse
    {
        $approvedBy = $request->validated('approved_by') ?? $request->user()?->id;
        $updated = $this->service->reject(
            $peminjaman,
            $request->validated('alasan_penolakan'),
            $approvedBy
        );

        return response()->json($updated);
    }
}
