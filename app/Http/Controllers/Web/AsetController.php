<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAsetRequest;
use App\Http\Requests\UpdateAsetRequest;
use App\Models\Aset;
use App\Models\KategoriAset;
use App\Models\LokasiAset;

class AsetController extends Controller
{
    public function index()
    {
        $aset = Aset::query()->with(['kategori', 'lokasi'])->latest()->paginate(10);
        $kategori = KategoriAset::query()->orderBy('nama')->get();
        $lokasi = LokasiAset::query()->orderBy('nama')->get();

        return view('aset.index', compact('aset', 'kategori', 'lokasi'));
    }

    public function store(StoreAsetRequest $request)
    {
        Aset::query()->create($request->validated());

        return back()->with('success', 'Aset berhasil ditambahkan.');
    }

    public function update(UpdateAsetRequest $request, Aset $aset)
    {
        $aset->update($request->validated());

        return back()->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy(Aset $aset)
    {
        $aset->delete();

        return back()->with('success', 'Aset berhasil dihapus.');
    }
}
