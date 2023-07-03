<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePrincipalRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'nip' => ['required', 'string'],
            'address' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'accounting_email' => ['required', 'string'],
            'website' => ['required', 'string'],
            'password' => ['nullable', 'string'],
            'phone' => ['required', 'string'],
        ];
    }
}
