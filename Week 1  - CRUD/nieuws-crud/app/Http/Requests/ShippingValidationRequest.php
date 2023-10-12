<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingValidationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'useDifferentBilling' => $this->useDifferentBilling ? true : false,
            'billing_zip_code' => strtoupper($this->input('billing_zip_code')),
        ]);
    }

    public function rules()
    {
        return [
        'billing_street' => 'required_if:useDifferentBilling,false',
        'billing_street_number' => 'required_if:useDifferentBilling,false',
        'billing_zip_code' => [
            'required_if:useDifferentBilling,false',
            'regex:/^\d{4}[A-Z]{2}$/',],
        'billing_city' => 'required_if:useDifferentBilling,false',
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
