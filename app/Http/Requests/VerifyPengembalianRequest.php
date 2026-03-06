<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyPengembalianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'diverifikasi_by' => ['nullable', 'exists:users,id'],
            'ditandatangani_oleh' => ['nullable', 'string', 'max:255'],
        ];
    }
}
