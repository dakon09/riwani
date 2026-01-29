<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UmkmImportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'File import harus dipilih',
            'file.file' => 'File harus berupa file yang valid',
            'file.mimes' => 'File harus berupa format Excel atau CSV',
            'file.max' => 'Ukuran file maksimal 10MB',
        ];
    }
}
