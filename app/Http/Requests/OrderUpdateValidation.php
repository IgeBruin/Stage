<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueProductInOrder;

class OrderUpdateValidation extends FormRequest
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
        $rules = [
        'telephone' => [
            'required',
            'regex:/^06\d{8}$/'
        ],
        'email' => 'required|email',
        'order_items.*.quantity' => 'required|integer|min:0',
        ];

        if ($this->filled('quantity')) {
            $rules['product'] = [
            'sometimes', 
            'required',
            'exists:products,id', 
            new UniqueProductInOrder($this->route('order')), 
            ];
        }

        return $rules;
    }


    public function messages()
    {
        return [
        'telephone.required' => 'Het veld Telefoonnummer is verplicht.',
        'telephone.regex' => 'Het veld Telefoonnummer moet een geldig Nederlands telefoonnummer zijn. Startend met 06 en gevolgd door 8 cijfers.',
        'email.required' => 'Het veld E-mail is verplicht.',
        'email.email' => 'Het veld E-mail moet een geldig e-mailadres zijn.',
        'order_items.*.quantity.required' => 'Aantal is verplicht voor alle producten.',
        'order_items.*.quantity.integer' => 'Het moet een geheel getal zijn.',
        'order_items.*.quantity.min' => 'Het moet minimaal 0 zijn.',
        ];
    }
}
