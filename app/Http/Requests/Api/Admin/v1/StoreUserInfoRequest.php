<?php

namespace App\Http\Requests\Api\Admin\v1;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserInfoRequest extends FormRequest
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
            'user_id' => ['required', 'integer', 'exists:users,id', 'unique:user_infos,user_id'],
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'birthdate' => ['required', 'date'],
            'profile_picture' => ['nullable', 'string']
        ];
    }
}
