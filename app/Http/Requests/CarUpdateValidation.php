<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarUpdateValidation extends FormRequest
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
            'title' => 'required|string|max:64',
            'description' => 'required|string',
            'brand_id' => 'required|exists:brands,id',
            'type_id' => 'required|exists:types,id',
            'fuel_id' => 'required|exists:fuels,id',
            'year' => 'required|nullable|integer|min:1900|max:' . (date('Y') + 1),
            'mileage' => 'required|nullable|integer|min:0',
            'mot' => 'required|nullable|date',
            'price' => 'required|numeric|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'title.required' => 'Het veld "Naam" is verplicht.',
            'title.string' => 'Het veld "Naam" moet een tekst zijn.',
            'title.max' => 'Het veld "Naam" mag niet meer dan :max karakters bevatten.',
            'description.required' => 'Het veld "Omschrijving" is verplicht.',
            'description.string' => 'Het veld "Omschrijving" moet een tekst zijn.',
            'brand_id.required' => 'Het veld "Merk" is verplicht.',
            'brand_id.exists' => 'Het geselecteerde merk is ongeldig.',
            'type_id.required' => 'Het veld "Type" is verplicht.',
            'type_id.exists' => 'Het geselecteerde type is ongeldig.',
            'fuel_id.required' => 'Het veld "Brandstof" is verplicht.',
            'fuel_id.exists' => 'De geselecteerde brandstof is ongeldig.',
            'year.nullable' => 'Het veld "Bouwjaar" is verplicht.',
            'year.required' => 'Het veld "Bouwjaar" is verplicht.',
            'year.integer' => 'Vul een geldig jaartal in. bijv. (2010)',
            'year.min' => 'Het veld "Bouwjaar" moet minimaal :min zijn.',
            'year.max' => 'Het veld "Bouwjaar" mag niet meer dan :max zijn.',
            'mileage.nullable' => 'Het veld "Kilometerstand" is verplicht.',
            'mileage.required' => 'Het veld "Kilometerstand" is verplicht.',
            'mileage.integer' => 'Het veld "Kilometerstand" moet een geheel getal zijn.',
            'mileage.min' => 'Het veld "Kilometerstand" moet minimaal :min zijn.',
            'mot.nullable' => 'Het veld "Laatste APK datum" is verplicht.',
            'mot.required' => 'Het veld "Laatste APK datum" is verplicht.',
            'mot.date' => 'Het veld "Laatste APK datum" moet een geldige datum zijn.',
            'price.required' => 'Het veld "Prijs" is verplicht.',
            'price.numeric' => 'Het veld "Prijs" moet een numerieke waarde zijn.',
            'price.min' => 'Het veld "Prijs" moet minimaal :min zijn.',
            'images.*.image' => 'Het veld "Afbeeldingen" moet een afbeelding zijn.',
            'images.*.mimes' => 'Het veld "Afbeeldingen" moet een van de volgende bestandstypes bevatten: :values.',
            'images.*.max' => 'Het veld "Afbeeldingen" mag niet groter zijn dan :max kilobytes.',
        ];
    }
}
