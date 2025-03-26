<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UserInfoRequest extends FormRequest
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
            'firstname' => ['string', 'sometimes'],
            'lastname' => ['string', 'sometimes'],
            'phone' => ['string', 'size:11', 'sometimes'],
            'birthdate' => ['date', 'sometimes'],
            'profile_picture' => ['string', 'sometimes']
        ];
    }
}
