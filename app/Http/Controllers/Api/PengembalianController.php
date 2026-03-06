<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePengembalianRequest;
use App\Http\Requests\VerifyPengembalianRequest;
use App\Models\PengembalianAset;
use App\Services\PengembalianService;
use Illuminate\Http\JsonResponse;

class PengembalianController extends Controller
{
    public function __construct(private readonly PengembalianService $service)
    {
    }

    public function index(): JsonResponse
    {
        $data = PengembalianAset::query()
            ->with(['peminjaman.aset', 'beritaAcara', 'verifier'])
            ->latest()
            ->paginate(10);

        return response()->json($data);
    }

    public function store(StorePengembalianRequest $request): JsonResponse
    {
        $pengembalian = $this->service->create($request->validated());

        return response()->json($pengembalian->load(['peminjaman.aset']), 201);
    }

    public function verify(VerifyPengembalianRequest $request, PengembalianAset $pengembalian): JsonResponse
    {
        $verifiedBy = $request->validated('diverifikasi_by') ?? $request->user()?->id;

        $result = $this->service->verify(
            $pengembalian,
            $verifiedBy,
            $request->validated('ditandatangani_oleh')
        );

        return response()->json($result);
    }
}
