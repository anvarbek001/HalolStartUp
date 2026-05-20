<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Override;

class BrandStoreRequest extends FormRequest
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
            'name' => 'required|string',
            'stir' => 'required',
            'viloyat_id' => 'required',
            'description' => 'required',
            'license' => 'required|mimes:jpg,png,jpeg,pdf|max:4048',
            'logo' => 'required|mimes:jpg,png,jpeg|max:4048'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Brend nomi majburiy",
            'stir.required' => 'STIR majburiy',
            'viloyat_id.required' => 'Viloyat majburiy',
            'description.required' => 'Izoh majburiy',
            'license.required' => 'Litsenziya majburiy',
            'logo.required' => 'Logotip majburiy',
        ];
    }
}
