<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKategoriAsetRequest;
use App\Http\Requests\UpdateKategoriAsetRequest;
use App\Models\KategoriAset;
use Illuminate\Http\JsonResponse;

class KategoriAsetController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(KategoriAset::query()->latest()->paginate(10));
    }

    public function store(StoreKategoriAsetRequest $request): JsonResponse
    {
        $kategori = KategoriAset::query()->create($request->validated());

        return response()->json($kategori, 201);
    }

    public function show(KategoriAset $kategoriAset): JsonResponse
    {
        return response()->json($kategoriAset);
    }

    public function update(UpdateKategoriAsetRequest $request, KategoriAset $kategoriAset): JsonResponse
    {
        $kategoriAset->update($request->validated());

        return response()->json($kategoriAset->fresh());
    }

    public function destroy(KategoriAset $kategoriAset): JsonResponse
    {
        $kategoriAset->delete();

        return response()->json(['message' => 'Kategori aset berhasil dihapus.']);
    }
}
