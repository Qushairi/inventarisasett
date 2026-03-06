<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAsetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $aset = $this->route('aset');
        $asetId = is_object($aset) ? $aset->id : (int) $aset;

        return [
            'kode_aset' => ['required', 'string', 'max:100', Rule::unique('aset', 'kode_aset')->ignore($asetId)],
            'nama' => ['required', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'kategori_aset_id' => ['required', 'exists:kategori_aset,id'],
            'lokasi_aset_id' => ['required', 'exists:lokasi_aset,id'],
            'kondisi' => ['required', 'in:baik,rusak_ringan,rusak_berat'],
            'status' => ['required', 'in:tersedia,dipinjam,maintenance'],
            'tanggal_perolehan' => ['nullable', 'date'],
            'nilai_perolehan' => ['nullable', 'numeric', 'min:0'],
            'keterangan' => ['nullable', 'string'],
        ];
    }
}
