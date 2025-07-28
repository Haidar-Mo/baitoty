<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\AssignKitchenRule;
use Illuminate\Foundation\Http\FormRequest;

class KitchenCreateRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id', new AssignKitchenRule()],
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'phone_number' => ['required', 'string', 'unique:users,phone_number'],
            'second_phone_number' => ['nullable', 'string'],
            'latitude' => ['required', 'numeric', 'min:-90', 'max:90'],
            'longitude' => ['required', 'numeric', 'min:-180', 'max:180'],
            'can_deliver' => ['boolean', 'nullable'],
            'open_at' => ['required', 'date_format:H:i'],
            'close_at' => ['required', 'date_format:H:i'],
        ];
    }
}
