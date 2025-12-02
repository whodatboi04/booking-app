<?php

namespace App\Http\Requests\Api\Admin\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class PaymentRequest extends FormRequest
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

        if (Route::is('admin.payment.update')) {
            return [
                'status' => ['sometimes', 'integer']
            ];
        }

        return [
            'total_amount' => ['required', 'numeric'],
            'payment_method_id' => ['required', 'integer'],
        ];
    }
}
