<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\AssignKitchenRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'user_id' => ['sometimes', 'exists:users,id', new AssignKitchenRule()],
            'name' => ['sometimes', 'string'],
            'description' => ['nullable', 'string'],
            'phone_number' => ['sometimes', 'string', 'unique:kitchens,phone_number', Rule::unique('kitchens')->ignore($this->route('phone_number'))],
            'second_phone_number' => ['nullable', 'string'],
            'latitude' => ['sometimes', 'numeric', 'min:-90', 'max:90'],
            'longitude' => ['sometimes', 'numeric', 'min:-180', 'max:180'],
            'can_deliver' => ['boolean', 'nullable'],
            'open_at' => ['sometimes', 'date_format:H:i'],
            'close_at' => ['sometimes', 'date_format:H:i'],
        ];
    }
}
