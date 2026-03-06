<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'aset_id' => ['required', 'exists:aset,id'],
            'pegawai_id' => ['nullable', 'exists:users,id'],
            'tanggal_pinjam' => ['required', 'date'],
            'tanggal_rencana_kembali' => ['nullable', 'date', 'after_or_equal:tanggal_pinjam'],
            'keterangan' => ['nullable', 'string'],
        ];
    }
}
