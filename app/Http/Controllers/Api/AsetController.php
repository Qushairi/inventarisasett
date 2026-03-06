<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAsetRequest;
use App\Http\Requests\UpdateAsetRequest;
use App\Models\Aset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AsetController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $aset = Aset::query()
            ->with(['kategori', 'lokasi'])
            ->when($request->string('status')->isNotEmpty(), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->integer('kategori_aset_id') > 0, fn ($q) => $q->where('kategori_aset_id', $request->integer('kategori_aset_id')))
            ->when($request->integer('lokasi_aset_id') > 0, fn ($q) => $q->where('lokasi_aset_id', $request->integer('lokasi_aset_id')))
            ->latest()
            ->paginate(10);

        return response()->json($aset);
    }

    public function store(StoreAsetRequest $request): JsonResponse
    {
        $aset = Aset::query()->create($request->validated());

        return response()->json($aset->load(['kategori', 'lokasi']), 201);
    }

    public function show(Aset $aset): JsonResponse
    {
        return response()->json($aset->load(['kategori', 'lokasi']));
    }

    public function update(UpdateAsetRequest $request, Aset $aset): JsonResponse
    {
        $aset->update($request->validated());

        return response()->json($aset->fresh(['kategori', 'lokasi']));
    }

    public function destroy(Aset $aset): JsonResponse
    {
        $aset->delete();

        return response()->json(['message' => 'Aset berhasil dihapus.']);
    }
}
