<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CustomerRegisterRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => ['required', 'email', Rule::unique('customers', 'email')],
            'phone' => 'nullable|max:20',
            'password' => 'required|min:6|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Foydalanuvchi nomi kiritilmagan",
            'email.required' => "Email kiritilmagan",
            'email.unique' => "Bu email allaqachon ro'yxatdan o'tgan",
            'password.required' => "Parol kiritilmagan",
        ];
    }
}
