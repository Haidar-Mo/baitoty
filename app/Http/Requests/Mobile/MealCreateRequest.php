<?php

namespace App\Http\Requests\Mobile;

use Illuminate\Foundation\Http\FormRequest;

class MealCreateRequest extends FormRequest
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
            'name' => 'required|string',
            'ingredients' => 'required|string',
            'type' => 'required|integer',
            'price' => 'required|decimal:0,2',
            'meal_form' => 'required|string',
            'attribute' => 'sometimes|array',
            'attribute*' => 'string',
            'image' => 'sometimes|array',
            'image*' => 'image'
        ];
    }
}
