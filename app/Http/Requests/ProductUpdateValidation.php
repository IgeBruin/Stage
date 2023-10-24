<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateValidation extends FormRequest
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
            'name' => 'required|string|max:64',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'vat' => 'required|numeric|min:0|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'Het veld "Naam" is verplicht.',
            'name.string' => 'Het veld "Naam" moet een tekst zijn.',
            'name.max' => 'Het veld "Naam" mag niet meer dan :max karakters bevatten.',
            'description.required' => 'Het veld "Omschrijving" is verplicht.',
            'description.string' => 'Het veld "Omschrijving" moet een tekst zijn.',
            'price.required' => 'Het veld "Prijs" is verplicht.',
            'price.numeric' => 'Het veld "Prijs" moet een numerieke waarde zijn.',
            'price.min' => 'Het veld "Prijs" moet minimaal :min zijn.',
            'stock.required' => 'Het veld "Voorraad" is verplicht.',
            'stock.integer' => 'Het veld "Voorraad" moet een geheel getal zijn.',
            'stock.min' => 'Het veld "Voorraad" moet minimaal :min zijn.',
            'vat.required' => 'Het veld "Belastingpercentage" is verplicht.',
            'vat.numeric' => 'Het veld "Belastingpercentage" moet een numerieke waarde zijn.',
            'vat.min' => 'Het veld "Belastingpercentage" moet minimaal :min zijn.',
            'vat.max' => 'Het veld "Belastingpercentage" mag niet meer dan :max zijn.',
            'image.image' => 'Het veld "Afbeelding" moet een afbeelding zijn.',
            'image.mimes' => 'Het veld "Afbeelding" moet een van de volgende bestandstypes bevatten: :values.',
            'image.max' => 'Het veld "Afbeelding" mag niet groter zijn dan :max kilobytes.',
        ];
    }
}
