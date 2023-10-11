<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingValidationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'shipping_street' => 'required',
            'shipping_street_number' => 'required',
            'shipping_zip_code' => 'required|regex:/\b\d{4}[A-Z]{2}\b/i', // Nederlandse postcode
            'shipping_city' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'shipping_street.required' => 'Het veld "Straat" is verplicht.',
            'shipping_street_number.required' => 'Het veld "Huisnummer" is verplicht.',
            'shipping_zip_code.required' => 'Het veld "Postcode" is verplicht.',
            'shipping_zip_code.regex' => 'Voer een geldige Nederlandse postcode in (1234AB).',
            'shipping_city.required' => 'Het veld "Stad" is verplicht.',
        ];
    }
}
