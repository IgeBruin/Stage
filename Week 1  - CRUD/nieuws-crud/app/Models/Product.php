<?php

namespace App\models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'fat', 'stock'
    ];
    
    public function specifications()
    {
        return $this->belongsToMany(Specification::class, 'product_specifications')->withPivot('value');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product')->withTimestamps();
    }
}
