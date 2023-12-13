<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactStoreValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // You can customize the authorization logic if needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => [
                'required',
                'regex:/^(\+[0-9]{1,3}[-\s]?)?(\([0-9]{1,5}\)[-.\s]?)?([0-9][0-9.\-\s]{0,11})+$/',
            ],
            'message' => 'required|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Vul uw naam in.',
            'name.string' => 'De naam moet een tekst zijn.',
            'name.max' => 'De naam mag niet meer dan :max tekens bevatten.',

            'email.required' => 'Vul uw e-mailadres in.',
            'email.email' => 'Vul een geldig e-mailadres in.',
            'email.max' => 'Het e-mailadres mag niet meer dan :max tekens bevatten.',

            'phone.required' => 'Vul uw telefoonnummer in.',
            'phone.regex' => 'Vul een geldig telefoonnummer in.',

            'message.required' => 'Vul uw bericht in.',
            'message.string' => 'Het bericht moet een tekst zijn.',
        ];
    }
}
