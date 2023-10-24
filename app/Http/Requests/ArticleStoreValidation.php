<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleStoreValidation extends FormRequest
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
            "category_id" => "required|exists:categories,id",
            "publication_date" => "required|date",
            "image" => "file|mimes:jpeg,jpg,,png,gif,|max:20000", // 20mb
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Een titel is verplicht.',
            'title.max' => 'Een titel mag maximaal 64 karakters hebben',
            'introduction.required' => 'Een introductie is verplicht.',
            'content.required' => 'Inhoud is verplicht.',
            'category_id.required' => 'Een categorie is verplicht.',
            'category_id.exists' => 'De geselecteerde categorie bestaat niet.',
            'publication_date.required' => 'Een publicatiedatum is verplicht.',
            'publication_date.date' => 'De publicatiedatum moet een geldige datum zijn.',
            'image.mimes' => 'Het bestand moet een jpeg,png,jpg,gif, bestand zijn.',
        ];
    }
}
