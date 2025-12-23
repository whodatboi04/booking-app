<?php

namespace App\Http\Requests\Api\Admin\v1;

use Illuminate\Foundation\Http\FormRequest;

class IndexManageBookingRequest extends FormRequest
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
            'search' => ['nullable', 'string'],
            'status' => ['nullable', 'integer'],
            'per_page' => ['nullable', 'integer'],
            'start_date_to' => ['nullable', 'date'],
            'start_date_from' => ['nullable', 'date'],
            'end_date_to' => ['nullable', 'date'],
            'end_date_from' => ['nullable', 'date'],
        ];
    }
}
