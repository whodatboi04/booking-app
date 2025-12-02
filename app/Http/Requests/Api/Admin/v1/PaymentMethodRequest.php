<?php

namespace App\Http\Requests\Api\Admin\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class PaymentMethodRequest extends FormRequest
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
        if (Route::is('payment-method.index')) {
            return [
                'search' => ['nullable', 'string'],
                'status' => ['nullable', 'integer'],
                'perPage' => ['nullable', 'integer']
            ];
        }

        return [
            'name' => ['required', 'string', 'unique:payment_methods,name']
        ];
    }
}
