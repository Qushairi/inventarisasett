<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLokasiAsetRequest;
use App\Http\Requests\UpdateLokasiAsetRequest;
use App\Models\LokasiAset;
use Illuminate\Http\JsonResponse;

class LokasiAsetController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(LokasiAset::query()->latest()->paginate(10));
    }

    public function store(StoreLokasiAsetRequest $request): JsonResponse
    {
        $lokasi = LokasiAset::query()->create($request->validated());

        return response()->json($lokasi, 201);
    }

    public function show(LokasiAset $lokasiAset): JsonResponse
    {
        return response()->json($lokasiAset);
    }

    public function update(UpdateLokasiAsetRequest $request, LokasiAset $lokasiAset): JsonResponse
    {
        $lokasiAset->update($request->validated());

        return response()->json($lokasiAset->fresh());
    }

    public function destroy(LokasiAset $lokasiAset): JsonResponse
    {
        $lokasiAset->delete();

        return response()->json(['message' => 'Lokasi aset berhasil dihapus.']);
    }
}
