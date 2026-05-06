<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Override;

class PartyStoreRequest extends FormRequest
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
            'name' => 'required',
            'price' => 'required',
            'rating' => 'nullable',
            'description' => 'string',
            'image' => 'required|mimes:jpg,png,jpeg,max:4096'
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            'name.required'   => 'Mahsulot nomi majburiy',
            'price.required'  => 'Narx majburiy',
            'price.numeric'   => 'Narx faqat raqam bo\'lishi kerak',
            'image.required'  => 'Rasm majburiy',
            'image.mimes'     => 'Rasm jpg, png, jpeg formatida bo\'lishi kerak',
            'image.max'       => 'Rasm hajmi 4MB dan oshmasligi kerak',
        ];
    }
}
