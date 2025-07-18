<?php

namespace App\Http\Requests\Api\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class RoomTypeRequest extends FormRequest
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
    public function rules(Request $request): array
    {

        if ($request->routeIs('client.room-types.index')) {
            return [
                'search' => ['nullable', 'string'],
                'persons' => ['nullable', 'integer'],
                'perPage' => ['nullable', 'integer']
            ];
        }

        return [
            //
        ];
    }
}
