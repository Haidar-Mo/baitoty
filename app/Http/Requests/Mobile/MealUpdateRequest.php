<?php

namespace App\Http\Requests\Mobile;

use Illuminate\Foundation\Http\FormRequest;

class MealUpdateRequest extends FormRequest
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
            'name' => 'sometimes|string',
            'ingredients' => 'sometimes|string',
            'type' => 'sometimes|integer',
            'price' => 'sometimes|decimal:0,2',
            'meal_form' => 'sometimes|string',
            'attribute' => 'sometimes|array',
            'attribute*' => 'string',

        ];
    }
}
