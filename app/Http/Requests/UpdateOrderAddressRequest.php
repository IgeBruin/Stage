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
        
            $rules = [];

        if ($this->has('billing_street') && $this->has('billing_street_number')) {
            $rules['billing_street'] = 'required|string';
            $rules['billing_street_number'] = 'required|string';
            $rules['billing_zip_code'] = ['required', 'regex:/^\d{4}[A-Z]{2}$/'];
            $rules['billing_city'] = 'required|string';
        }

        if ($this->has('shipping_street') && $this->has('shipping_street_number')) {
            $rules['shipping_street'] = 'required|string';
            $rules['shipping_street_number'] = 'required|string';
            $rules['shipping_zip_code'] = ['required', 'regex:/^\d{4}[A-Z]{2}$/'];
            $rules['shipping_city'] = 'required|string';
        }

            return $rules;
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
