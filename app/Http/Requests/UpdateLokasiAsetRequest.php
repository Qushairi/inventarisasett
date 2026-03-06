<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLokasiAsetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $lokasi = $this->route('lokasiAset') ?? $this->route('lokasi_aset');
        $lokasiId = is_object($lokasi) ? $lokasi->id : (int) $lokasi;

        return [
            'nama' => ['required', 'string', 'max:255'],
            'kode' => ['required', 'string', 'max:50', Rule::unique('lokasi_aset', 'kode')->ignore($lokasiId)],
            'alamat' => ['nullable', 'string'],
            'keterangan' => ['nullable', 'string'],
        ];
    }
}
