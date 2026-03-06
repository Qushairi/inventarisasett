<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKategoriAsetRequest;
use App\Http\Requests\UpdateKategoriAsetRequest;
use App\Models\KategoriAset;

class KategoriAsetController extends Controller
{
    public function index()
    {
        $kategori = KategoriAset::query()->latest()->paginate(10);

        return view('kategori-aset.index', compact('kategori'));
    }

    public function store(StoreKategoriAsetRequest $request)
    {
        KategoriAset::query()->create($request->validated());

        return back()->with('success', 'Kategori aset berhasil ditambahkan.');
    }

    public function update(UpdateKategoriAsetRequest $request, KategoriAset $kategoriAset)
    {
        $kategoriAset->update($request->validated());

        return back()->with('success', 'Kategori aset berhasil diperbarui.');
    }

    public function destroy(KategoriAset $kategoriAset)
    {
        $kategoriAset->delete();

        return back()->with('success', 'Kategori aset berhasil dihapus.');
    }
}
