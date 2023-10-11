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
            'useDifferentBilling' => $this->useDifferentBilling ? true : false
        ]);
    }

    public function rules()
    {
        return $rules = [
            
        'shipping_street' => 'required_if:useDifferentBilling,false',
        'shipping_street_number' => 'required_if:useDifferentBilling,false',
        'shipping_zip_code' => 'required_if:useDifferentBilling,false|regex:/^[1-9][0-9]{3} ?(?!sa|sd|ss)[a-z]{2}$/i',
        'shipping_city' => 'required_if:useDifferentBilling,false',
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
