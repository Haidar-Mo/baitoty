<?php

namespace App\Http\Requests\Mobile;

use Illuminate\Foundation\Http\FormRequest;

class KitchenUpdateRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'phone_number' => ['sometimes', 'string', 'max:20'],
            'second_phone_number' => ['sometimes', 'string', 'max:20'],
            'longitude' => ['sometimes', 'numeric'],
            'latitude' => ['sometimes', 'numeric'],
            'open_at' => ['sometimes', 'date_format:H:i'],
            'close_at' => ['sometimes', 'date_format:H:i'],
            'can_deliver' => ['sometimes', 'boolean']
        ];
    }
}
