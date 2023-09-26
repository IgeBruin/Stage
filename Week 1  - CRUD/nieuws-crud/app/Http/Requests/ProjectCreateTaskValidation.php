<?php

namespace App\Http\Requests;

use GuzzleHttp\Psr7\Message;
use Illuminate\Foundation\Http\FormRequest;

class ProjectCreateTaskValidation extends FormRequest
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
            "title" => "required|string|max:64",
            "description" => "required|string",
            "deadline" => "required|date",
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Een titel is verplicht.',
            'title.max' => 'Een titel mag maximaal 64 karakters hebben',
            'description.required' => 'Een beschrijving is verplicht.',
            'deadline.required' => 'Een deadline is verplicht.',
            'deadline.date' => 'De deadline moet een geldige datum zijn.',
        ];
    }
}
