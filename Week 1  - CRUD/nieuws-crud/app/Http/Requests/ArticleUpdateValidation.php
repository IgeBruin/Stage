<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleUpdateValidation extends FormRequest
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
            "title" => "required|max:64",
            "introduction" => "required",
            "content" => "required",
            "publication_date" => "required|date",
            "category_id" => "required|exists:categories,id",
            "image" => "file|mimes:jpeg,jpg,,png,gif,|max:20000", // 20mb
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'title.required' => 'Een titel is verplicht.',
            'title.max' => 'Een titel mag maximaal 64 karakters hebben',
            'introduction.required' => 'Een introductie is verplicht.',
            'content.required' => 'Inhoud is verplicht.',
            'publication_date.required' => 'Een publicatiedatum is verplicht.',
            'publication_date.date' => 'De publicatiedatum moet een geldige datum zijn.',
            'category_id.required' => 'Een categorie is verplicht.',
            'category_id.exists' => 'De geselecteerde categorie bestaat niet.',
            'image.mimes' => 'Het bestand moet een jpeg,png,jpg,gif, bestand zijn.',
        ];
    }
}
