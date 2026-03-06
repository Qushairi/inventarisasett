<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKategoriAsetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $kategori = $this->route('kategoriAset') ?? $this->route('kategori_aset');
        $kategoriId = is_object($kategori) ? $kategori->id : (int) $kategori;

        return [
            'nama' => ['required', 'string', 'max:255'],
            'kode' => ['required', 'string', 'max:50', Rule::unique('kategori_aset', 'kode')->ignore($kategoriId)],
            'deskripsi' => ['nullable', 'string'],
        ];
    }
}
