<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSpecificationsValidation extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'specifications' => 'required|array',
            'specifications.*' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'specifications.required' => 'Specificaties zijn verplicht.',
            'specifications.*.required' => 'Dit veld is verplicht en mag niet leeg zijn.',
            'specifications.*.string' => 'Dit veld moet een tekst zijn.',
        ];
    }
}
