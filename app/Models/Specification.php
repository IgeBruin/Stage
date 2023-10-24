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
}
