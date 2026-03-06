<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAsetRequest;
use App\Http\Requests\UpdateAsetRequest;
use App\Models\Aset;
use App\Models\KategoriAset;
use App\Models\LokasiAset;
use Illuminate\Support\Facades\Storage;

class AsetController extends Controller
{
    public function index()
    {
        $aset = Aset::query()->with(['kategori', 'lokasi'])->latest()->paginate(10);
        $kategori = KategoriAset::query()->orderBy('nama')->get();
        $lokasi = LokasiAset::query()->orderBy('nama')->get();

        return view('aset.index', compact('aset', 'kategori', 'lokasi'));
    }

    public function show(Aset $aset)
    {
        $aset->load(['kategori', 'lokasi']);

        return view('aset.show', compact('aset'));
    }

    public function store(StoreAsetRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('aset-photos', 'public');
        }

        Aset::query()->create($data);

        return back()->with('success', 'Aset berhasil ditambahkan.');
    }

    public function update(UpdateAsetRequest $request, Aset $aset)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($aset->foto) {
                Storage::disk('public')->delete($aset->foto);
            }

            $data['foto'] = $request->file('foto')->store('aset-photos', 'public');
        } else {
            unset($data['foto']);
        }

        $aset->update($data);

        return back()->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy(Aset $aset)
    {
        if ($aset->foto) {
            Storage::disk('public')->delete($aset->foto);
        }

        $aset->delete();

        return back()->with('success', 'Aset berhasil dihapus.');
    }
}
