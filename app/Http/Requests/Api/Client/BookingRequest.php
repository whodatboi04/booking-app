<?php

namespace App\Http\Requests\Api\Client;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'room_type_id' => ['required', 'integer'],
            'discount_id' => ['nullable', 'integer'],
            'firstname' => ['required', 'string'],
            'middlename' => ['nullable', 'string'],
            'lastname' => ['required', 'string'],
            'email' => ['required', 'email'],
            'discount_id_picture' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'number_of_persons' => ['required', 'integer'],
            'start_date' => ['required', 'date', 'before_or_equal:end_date', 'after:' . time_now()],
            'end_date' => ['required', 'date', 'after_or_equal:start_date', 'after:' . time_now()]
        ];
    }

    public function messages()
    {
        return [
            'start_date.after' => 'You must enter start date after the current date',
            'end_date.after' => 'You must enter end date after the current date',
        ];
    }
}
