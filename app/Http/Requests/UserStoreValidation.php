<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreValidation extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'isAdmin' => 'nullable|boolean',
            'password' => 'required|string|min:8|confirmed',
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
        'name.nullable' => 'Het naamveld is verplicht.',
        'name.required' => 'Het naamveld is verplicht.',
        'email.required' => 'Het e-mailveld is verplicht.',
        'email.unique' => 'Dit e-mailadres is al in gebruik.',
        'phone.required' => 'Het telefoonveld is verplicht.',
        'address.required' => 'Het adresveld is verplicht.',
        'isAdmin.boolean' => 'De waarde van Is Admin moet een boolean zijn.',
        'password.required' => 'Het wachtwoordveld is verplicht.',
        'password.min' => 'Het wachtwoord moet minimaal 8 tekens lang zijn.',
        'password.confirmed' => 'Het wachtwoord komt niet overeen met de bevestiging.',
        ];
    }
}
