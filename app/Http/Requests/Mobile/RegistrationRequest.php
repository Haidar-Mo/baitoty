<?php

namespace App\Http\Requests\Mobile;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'role' => 'required|in:client,chef',

            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:6',
            'name' => 'required|string',

            'kitchen_name' => 'required_if:role,chef|string',
            'city_id' => 'required_if:role,chef|exists:cities,id',
            'kitchen_address' => 'required_if:role,chef|string',
            'kitchen_description' => 'required_if:role,chef|string',
            'kitchen_phone_number' => 'required_if:role,chef|string',
            'kitchen_second_phone_number' => 'nullable',
        ];
    }
}
