<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreValidation extends FormRequest
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
            "name" => "required|string|max:64",
            "introduction" => "required|string",
            "content" => "required|string",
            "start_date" => "required|date", 
            "image" => "image|mimes:jpeg,png,jpg,gif|max:2048", 
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Een titel is verplicht.',
            'name.max' => 'Een titel mag maximaal 64 karakters hebben',
            'introduction.required' => 'Een introductie is verplicht.',
            'content.required' => 'Inhoud is verplicht.',
            'start_date.required' => 'Een startdatum is verplicht.',
            'start_date.date' => 'De startdatum moet een geldige datum zijn.',
            'image.mimes' => 'Het bestand moet een jpeg, png, jpg of gif-bestand zijn.',
        ];
    }
}
