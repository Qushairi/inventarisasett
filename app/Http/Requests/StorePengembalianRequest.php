<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengembalianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'peminjaman_aset_id' => ['required', 'exists:peminjaman_aset,id'],
            'tanggal_kembali' => ['required', 'date'],
            'kondisi_saat_kembali' => ['required', 'in:baik,rusak_ringan,rusak_berat'],
            'catatan' => ['nullable', 'string'],
        ];
    }
}
