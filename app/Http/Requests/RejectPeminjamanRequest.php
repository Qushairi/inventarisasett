<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RejectPeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'approved_by' => ['nullable', 'exists:users,id'],
            'alasan_penolakan' => ['required', 'string'],
        ];
    }
}
