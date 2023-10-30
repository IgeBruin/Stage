<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderAddressRequest extends FormRequest
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
            'billing_street' => 'required|string',
            'billing_street_number' => 'required|string',
            'billing_zip_code' => ['required', 'regex:/^\d{4}[A-Z]{2}$/'],
            'billing_city' => 'required|string',
            'shipping_street' => 'required|string',
            'shipping_street_number' => 'required|string',
            'shipping_zip_code' => ['required', 'regex:/^\d{4}[A-Z]{2}$/'],
            'shipping_city' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Het veld is verplicht.',
            'string' => 'Het veld moet een tekst zijn.',
            'regex' => 'Het veld Postcode moet bestaan uit 4 cijfers gevolgd door 2 letters (bijv. 1234AB).',
        ];
    }
}
