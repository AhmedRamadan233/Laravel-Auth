<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'nullable|string|unique:users,phone|max:255',
            'gender' => 'nullable|string|max:255',
            'role' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'password' => 'required|string|min:8',
        ];
    }
}
