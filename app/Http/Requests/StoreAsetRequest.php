<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAsetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode_aset' => ['required', 'string', 'max:100', 'unique:aset,kode_aset'],
            'nama' => ['required', 'string', 'max:255'],
            'kategori_aset_id' => ['required', 'exists:kategori_aset,id'],
            'lokasi_aset_id' => ['required', 'exists:lokasi_aset,id'],
            'kondisi' => ['required', 'in:baik,rusak_ringan,rusak_berat'],
            'status' => ['sometimes', 'in:tersedia,dipinjam,maintenance'],
            'tanggal_perolehan' => ['nullable', 'date'],
            'nilai_perolehan' => ['nullable', 'numeric', 'min:0'],
            'keterangan' => ['nullable', 'string'],
        ];
    }
}
