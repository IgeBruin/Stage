<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandStoreValidation extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:20|unique:brands',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'De merknaam is verplicht.',
            'name.string' => 'De merknaam moet een tekst zijn.',
            'name.max' => 'De merknaam mag maximaal 20 tekens bevatten.',
            'name.unique' => 'Deze merknaam is al in gebruik.',
        ];
    }
}
