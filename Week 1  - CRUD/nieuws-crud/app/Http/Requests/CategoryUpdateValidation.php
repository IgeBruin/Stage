<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateValidation extends FormRequest
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
        'name' => 'required|max:64|unique:categories,name,' . $this->category->id,
        'description' => 'required',
        "image" => "file|mimes:jpeg,jpg,,png,gif,|max:20000", // 20mb

        ];
    }

    public function messages()
    {
        return [
        'name.required' => 'Een categorie naam is verplicht.',
        'name.max' => 'Een titel mag maximaal 64 karakters hebben',
        'name.unique' => 'Deze categorie naam is al in gebruik.',
        'description.required' => 'Een omschrijving is verplicht',
        'image.mimes' => 'Het bestand moet een jpeg,png,jpg,gif, bestand zijn.',
        ];
    }
}
