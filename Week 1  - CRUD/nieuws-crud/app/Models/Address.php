<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'order_id',
        'type',
        'invoice',
        'shipping',
        'street',
        'street_number',
        'zip_code',
        'city',
        'name',
        'surname',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
