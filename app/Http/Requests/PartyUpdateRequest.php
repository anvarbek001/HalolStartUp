<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Override;

class PartyUpdateRequest extends FormRequest
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
            'name'             => 'required|string|max:255',
            'price'            => 'nullable|numeric|min:0',
            'rating'           => 'nullable|numeric|min:1|max:5',
            'description'      => 'required|string',
            'manufactured_at'  => 'nullable|date',
            'expires_at'       => 'nullable|date',
            'image'            => 'nullable|image|max:2048',
        ];
    }

    #[Override]
    public function attributes(): array
    {
        return [
            'name'            => 'Partiya nomi',
            'price'           => 'Mahsulot narxi',
            'rating'          => 'Reyting',
            'description'     => 'Izoh',
            'manufactured_at' => 'Ishlab chiqarilgan sana',
            'expires_at'      => 'Yaroqlilik muddati',
            'image'           => 'Rasm',
        ];
    }
}
