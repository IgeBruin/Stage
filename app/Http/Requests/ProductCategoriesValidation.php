<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoriesValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
        ];
    }

    /**
     * Get custom error messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'categories.array' => 'De geselecteerde categorieën moeten een array zijn.',
            'categories.*.exists' => 'Een of meer geselecteerde categorieën zijn ongeldig.',
        ];
    }
}
