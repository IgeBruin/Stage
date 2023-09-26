<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleStoreValidation extends FormRequest
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
        'name' => 'required|unique:roles|max:64',
        ];
    }

    public function messages()
    {
        return [
        'name.required' => 'Een rol naam is verplicht.',
        'name.unique' => 'Deze rol naam is al in gebruik.',
        'name.max' => 'Een titel mag maximaal 64 karakters hebben',

        ];
    }
}
