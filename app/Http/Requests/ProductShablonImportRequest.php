<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Override;

class ProductShablonImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file'     => 'required|mimes:xlsx,xls',
            'party_id' => 'required|exists:parties,id',
        ];
    }

    #[Override]
    public function attributes()
    {
        return [
            'file' => "Fayl"
        ];
    }
}
