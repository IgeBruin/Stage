<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreValidation extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        'name' => 'required|string',
        'surname' => 'required|string',
        'street' => 'required|string',
        'street_number' => 'required|string',
        'zip_code' => ['required', 'regex:/^\d{4}[A-Z]{2}|\d{4} ?[A-Z]{2}$/i'],
        'city' => 'required|string',
        'telephone' => [
            'required',
            'regex:/^06\d{8}$/'
        ],
        'email' => 'required|email',
        ];
    }


    public function messages()
    {
        return [
        'name.required' => 'Het veld Naam is verplicht.',
        'name.string' => 'Het veld Naam moet een tekst zijn.',
        'surname.required' => 'Het veld Achternaam is verplicht.',
        'surname.string' => 'Het veld Achternaam moet een tekst zijn.',
        'street.required' => 'Het veld Straat is verplicht.',
        'street.string' => 'Het veld Straat moet een tekst zijn.',
        'street_number.required' => 'Het veld Huisnummer is verplicht.',
        'street_number.string' => 'Het veld Huisnummer moet een tekst zijn.',
        'zip_code.required' => 'Het veld Postcode is verplicht.',
        'zip_code.regex' => 'Het veld Postcode moet bestaan uit 4 cijfers gevolgd door 2 letters (bijv. 1234AB).',
        'city.required' => 'Het veld Plaats is verplicht.',
        'city.string' => 'Het veld Plaats moet een tekst zijn.',
        'telephone.required' => 'Het veld Telefoonnummer is verplicht.',
        'telephone.regex' => 'Het veld Telefoonnummer moet een geldig nederlands telefoonnummer zijn. Startend met 06 en gevolgd door 8 cijfers.',
        'email.required' => 'Het veld E-mail is verplicht.',
        'email.email' => 'Het veld E-mail moet een geldig e-mailadres zijn.',
        ];
    }
}
