<?php

namespace App\models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
    ];

    public function productSpecifications()
    {
        return $this->hasMany(ProductSpecification::class);
    }

    public function carSpecifications()
    {
        return $this->belongsToMany(Car::class, 'car_specifications')->withPivot('value');
    }
}
