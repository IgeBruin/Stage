<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectAddUserValidation extends FormRequest
{
    public function rules()
    {
        $projectId = $this->route('project');
        return [
            "user_id" => [
                "required",
                "exists:users,id",
                Rule::unique('project_user')->where(function ($query) use ($projectId) {
                    return ($query->where('project_id', $projectId->id)->where('user_id', request()->user_id)->first());
                }),
            ],
        ];
    }

    public function messages()
    {
        return [
            "user_id.required" => "Een gebruikers-ID is verplicht.",
            "user_id.exists" => "De opgegeven gebruikers-ID bestaat niet in het systeem.",
            "user_id.unique" => "Deze gebruiker is al gekoppeld aan dit project.",
        ];
    }
}
