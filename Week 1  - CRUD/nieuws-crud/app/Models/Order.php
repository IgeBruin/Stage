<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'email',
        'telephone',
        'total_excl',
        'vat',
        'total_incl',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function billingAddress()
    {
        return $this->hasOne(Address::class)->where('type', 'billing');
    }

    public function shippingAddress()
    {
        return $this->hasOne(Address::class)->where('type', 'shipping');
    }
}
