<?php

namespace App\Http\Requests\Mobile;

use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
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
            'kitchen_id' => 'required|exists:kitchens,id',
            'meal_id' => 'required|exists:meals,id',
            'count' => 'required|numeric',
            'total_price'=>'required|numeric',
            'phone_number' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'notes' => 'sometimes|string',
        ];
    }
}
