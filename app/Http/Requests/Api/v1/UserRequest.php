<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

class UserRequest extends FormRequest
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
    public function rules()
    {
        if (Route::is('users.store')){
            return [
                'username' => ['required', 'string', 'unique:users,username'],
                'email' => ['required', 'string', 'email', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'password_confirmation' => ['required', 'string'],
                //Roles Object
                'roles.superadmin' => ['nullable', 'integer'],
                'roles.admin' => ['nullable', 'integer'],
                'roles.user' => ['nullable', 'integer']
            ];
        }

        elseif (Route::is('users.update')){
            return [
                'username' => ['sometimes', 'string', 'unique:users,username'],
                'email' => ['sometimes', 'string', 'email', 'unique:users,email'],
                'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
                //Roles Object
                'roles.superadmin' => ['nullable', 'integer'],
                'roles.admin' => ['nullable', 'integer'],
                'roles.user' => ['nullable', 'integer']
            ];
        }

        else {
            throw ValidationException::withMessages(['Invalid Route']);
        }
    }
}
