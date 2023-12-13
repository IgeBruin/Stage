<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpecificationUpdateValidation extends FormRequest
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
        'name' => 'required|max:64|unique:specifications,name,' . $this->specification->id,
        ];
    }

    public function messages()
    {
        return [
        'name.required' => 'Een specificatie naam is verplicht.',
        'name.unique' => 'Deze specificatie naam is al in gebruik.',
        'name.max' => 'Een naam van een specificatie mag maximaal 64 karakters hebben',
        ];
    }
}
