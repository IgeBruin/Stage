<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueProductInOrder implements Rule
{
    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function passes($attribute, $value)
    {
        return !$this->order->items->contains('product_id', $value);
    }

    public function message()
    {
        return 'Dit product is al aanwezig in de bestelling, pas de hoeveelheid aan.';
    }
}
