<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatusStoreValidation extends FormRequest
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
        'name' => 'required|unique:statuses|max:64',
        ];
    }

    public function messages()
    {
        return [
        'name.required' => 'Een status naam is verplicht.',
        'name.unique' => 'Deze status naam is al in gebruik.',
        'name.max' => 'Een titel van een status mag maximaal 64 karakters hebben',

        ];
    }
}
