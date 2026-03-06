<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLokasiAsetRequest;
use App\Http\Requests\UpdateLokasiAsetRequest;
use App\Models\LokasiAset;

class LokasiAsetController extends Controller
{
    public function index()
    {
        $lokasi = LokasiAset::query()->latest()->paginate(10);

        return view('lokasi-aset.index', compact('lokasi'));
    }

    public function store(StoreLokasiAsetRequest $request)
    {
        LokasiAset::query()->create($request->validated());

        return back()->with('success', 'Lokasi aset berhasil ditambahkan.');
    }

    public function update(UpdateLokasiAsetRequest $request, LokasiAset $lokasiAset)
    {
        $lokasiAset->update($request->validated());

        return back()->with('success', 'Lokasi aset berhasil diperbarui.');
    }

    public function destroy(LokasiAset $lokasiAset)
    {
        $lokasiAset->delete();

        return back()->with('success', 'Lokasi aset berhasil dihapus.');
    }
}
