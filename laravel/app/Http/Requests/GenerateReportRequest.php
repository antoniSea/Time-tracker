<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GenerateReportRequest extends FormRequest
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
            'principal' => ['required', 'integer', 'exists:principals,id'],
            'fromDate' => ['nullable', 'date'],
            'toDate' => ['nullable', 'date'],
            'fileFormat' => ['required', 'integer', 'in:1,2'],
        ];
    }
}
