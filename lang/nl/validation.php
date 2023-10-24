<?php
return [

/*
|--------------------------------------------------------------------------
| Validatietaalregels
|--------------------------------------------------------------------------
|
| De volgende taalregels bevatten de standaardfoutmeldingen die worden gebruikt door
| de validator-klasse. Sommige van deze regels hebben meerdere versies, zoals
| de grootteregels. Voel je vrij om elk van deze meldingen hier aan te passen.
|
*/

'accepted' => ':attribute moet worden geaccepteerd.',
'accepted_if' => ':attribute moet worden geaccepteerd wanneer :other :value is.',
'active_url' => ':attribute is geen geldige URL.',
'after' => ':attribute moet een datum zijn na :date.',
'after_or_equal' => ':attribute moet een datum zijn na of gelijk aan :date.',
'alpha' => ':attribute mag alleen letters bevatten.',
'alpha_dash' => ':attribute mag alleen letters, cijfers, streepjes en underscores bevatten.',
'alpha_num' => ':attribute mag alleen letters en cijfers bevatten.',
'array' => ':attribute moet een array zijn.',
'before' => ':attribute moet een datum zijn voor :date.',
'before_or_equal' => ':attribute moet een datum zijn voor of gelijk aan :date.',
'between' => [
    'numeric' => ':attribute moet tussen :min en :max liggen.',
    'file' => ':attribute moet tussen :min en :max kilobytes zijn.',
    'string' => ':attribute moet tussen :min en :max tekens zijn.',
    'array' => ':attribute moet tussen :min en :max items bevatten.',
],
'boolean' => ':attribute moet true of false zijn.',
'confirmed' => ':attribute bevestiging komt niet overeen.',
'current_password' => 'Het huidige wachtwoord is onjuist.',
'date' => ':attribute is geen geldige datum.',
'date_equals' => ':attribute moet een datum zijn gelijk aan :date.',
'date_format' => ':attribute komt niet overeen met het formaat :format.',
'declined' => ':attribute moet worden geweigerd.',
'declined_if' => ':attribute moet worden geweigerd wanneer :other :value is.',
'different' => ':attribute en :other moeten verschillend zijn.',
'digits' => ':attribute moet :digits cijfers bevatten.',
'digits_between' => ':attribute moet tussen :min en :max cijfers bevatten.',
'dimensions' => ':attribute heeft ongeldige afbeeldingsafmetingen.',
'distinct' => ':attribute veld heeft een dubbele waarde.',
'email' => ':attribute moet een geldig e-mailadres zijn.',
'ends_with' => ':attribute moet eindigen met een van de volgende: :values.',
'enum' => 'De geselecteerde :attribute is ongeldig.',
'exists' => 'De geselecteerde :attribute is ongeldig.',
'file' => ':attribute moet een bestand zijn.',
'filled' => ':attribute veld moet een waarde hebben.',
'gt' => [
    'numeric' => ':attribute moet groter zijn dan :value.',
    'file' => ':attribute moet groter zijn dan :value kilobytes.',
    'string' => ':attribute moet groter zijn dan :value tekens.',
    'array' => ':attribute moet meer dan :value items bevatten.',
],
'gte' => [
    'numeric' => ':attribute moet groter zijn dan of gelijk zijn aan :value.',
    'file' => ':attribute moet groter zijn dan of gelijk zijn aan :value kilobytes.',
    'string' => ':attribute moet groter zijn dan of gelijk zijn aan :value tekens.',
    'array' => ':attribute moet :value items of meer bevatten.',
],
'image' => ':attribute moet een afbeelding zijn.',
'in' => 'De geselecteerde :attribute is ongeldig.',
'in_array' => ':attribute veld bestaat niet in :other.',
'integer' => ':attribute moet een geheel getal zijn.',
'ip' => ':attribute moet een geldig IP-adres zijn.',
'ipv4' => ':attribute moet een geldig IPv4-adres zijn.',
'ipv6' => ':attribute moet een geldig IPv6-adres zijn.',
'json' => ':attribute moet een geldige JSON-tekenreeks zijn.',
'lt' => [
    'numeric' => ':attribute moet kleiner zijn dan :value.',
    'file' => ':attribute moet kleiner zijn dan :value kilobytes.',
    'string' => ':attribute moet kleiner zijn dan :value tekens.',
    'array' => ':attribute moet minder dan :value items bevatten.',
],
'lte' => [
    'numeric' => ':attribute moet kleiner zijn dan of gelijk zijn aan :value.',
    'file' => ':attribute moet kleiner zijn dan of gelijk zijn aan :value kilobytes.',
    'string' => ':attribute moet kleiner zijn dan of gelijk zijn aan :value tekens.',
    'array' => ':attribute mag niet meer dan :value items bevatten.',
],
'mac_address' => ':attribute moet een geldig MAC-adres zijn.',
'max' => [
    'numeric' => ':attribute mag niet groter zijn dan :max.',
    'file' => ':attribute mag niet groter zijn dan :max kilobytes.',
    'string' => ':attribute mag niet groter zijn dan :max tekens.',
    'array' => ':attribute mag niet meer dan :max items bevatten.',
],
'mimes' => ':attribute moet een bestandstype zijn van: :values.',
'mimetypes' => ':attribute moet een bestandstype zijn van: :values.',
'min' => [
    'numeric' => ':attribute moet minimaal :min zijn.',
    'file' => ':attribute moet minimaal :min kilobytes zijn.',
    'string' => ':attribute moet minimaal :min tekens zijn.',
    'array' => ':attribute moet minimaal :min items bevatten.',
],
'multiple_of' => ':attribute moet een veelvoud zijn van :value.',
'not_in' => 'De geselecteerde :attribute is ongeldig.',
'not_regex' => ':attribute formaat is ongeldig.',
'numeric' => ':attribute moet een nummer zijn.',
'password' => 'Het wachtwoord is onjuist.',
'present' => ':attribute veld moet aanwezig zijn.',
'prohibited' => ':attribute veld is verboden.',
'prohibited_if' => ':attribute veld is verboden wanneer :other :value is.',
'prohibited_unless' => ':attribute veld is verboden tenzij :other in :values is.',
'prohibits' => ':attribute veld verbiedt :other om aanwezig te zijn.',
'regex' => ':attribute formaat is ongeldig.',
'required' => ':attribute veld is verplicht.',
'required_array_keys' => ':attribute veld moet invoer bevatten voor: :values.',
'required_if' => ':attribute veld is verplicht wanneer :other :value is.',
'required_unless' => ':attribute veld is verplicht tenzij :other in :values is.',
'required_with' => ':attribute veld is verplicht wanneer :values aanwezig is.',
'required_with_all' => ':attribute veld is verplicht wanneer :values aanwezig zijn.',
'required_without' => ':attribute veld is verplicht wanneer :values niet aanwezig is.',
'required_without_all' => ':attribute veld is verplicht wanneer geen van :values aanwezig is.',
'same' => ':attribute en :other moeten overeenkomen.',
'size' => [
    'numeric' => ':attribute moet :size zijn.',
    'file' => ':attribute moet :size kilobytes zijn.',
    'string' => ':attribute moet :size tekens zijn.',
    'array' => ':attribute moet :size items bevatten.',
],
'starts_with' => ':attribute moet beginnen met een van de volgende: :values.',
'string' => ':attribute moet een tekenreeks zijn.',
'timezone' => ':attribute moet een geldige tijdzone zijn.',
'unique' => ':attribute is al in gebruik.',
'uploaded' => ':attribute kon niet worden geüpload.',
'url' => ':attribute moet een geldige URL zijn.',
'uuid' => ':attribute moet een geldige UUID zijn.',

/*
|--------------------------------------------------------------------------
| Aangepaste validatietaalregels
|--------------------------------------------------------------------------
|
| Hier kun je aangepaste validatiemeldingen voor attributen opgeven met de
| conventie "attribute.rule" om de regels te benoemen. Dit maakt het snel om
| een specifieke aangepaste taalregel op te geven voor een bepaalde attribuutregel.
|
*/

'custom' => [
    'attribute-name' => [
        'rule-name' => 'aangepaste-melding',
    ],
],

/*
|--------------------------------------------------------------------------
| Aangepaste validatieattributen
|--------------------------------------------------------------------------
|
| De volgende taalregels worden gebruikt om onze attribuutvervanging
| placeholder te vervangen door iets leesbaarders, zoals "E-mailadres" in plaats
| van "email". Dit helpt ons eenvoudigere en begrijpelijkere meldingen te maken.
|
*/

'attributes' => [],

];
