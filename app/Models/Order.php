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
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function billingAddress()
    {
        return $this->hasOne(Address::class)->where('type', 'Invoice');
    }

    public function shippingAddress()
    {
        return $this->hasOne(Address::class)->where('type', 'Shipping');
    }

    public function calculateTotals()
    {
        $totalExcl = 0;
        $vat = 0;
    
        foreach ($this->items as $item) {
            $totalExcl += $item->price * $item->quantity;
            $vat += $item->price * $item->quantity * ($item->vat / 100);
        }
    
        $totalIncl = $totalExcl + $vat;
    
        return $this->update([
            'total_excl' => $totalExcl,
            'vat' => $vat,
            'total_incl' => $totalIncl,
        ]);
    }
    
}
