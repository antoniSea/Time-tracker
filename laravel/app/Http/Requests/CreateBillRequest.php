<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CreateBillRequest extends FormRequest
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
            'hours' => ['required', 'numeric'],
            'rate' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'description' => ['nullable', 'string'],
            'principal_id' => ['required', 'numeric'],
        ];
    }

    /**
     * Get the validated data from the request.
     *
     * @param string|null $key
     * @param mixed|null $default
     * @return array<string, mixed>
     */
    public function validated($key = null, $default = null): array
    {
        return array_merge(parent::validated(), [
            'url_token' => Str::random(32),
            'user_id' => auth()->id(),
        ]);
    }
}
