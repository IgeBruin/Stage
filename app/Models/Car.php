<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'brand_id', 'type_id', 'fuel_id', 'year', 'mileage', 'mot', 'price',  'user_id'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    public function fuel()
    {
        return $this->belongsTo(Fuel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specifications()
    {
        return $this->belongsToMany(Specification::class, 'car_specifications')->withPivot('value');
    }

    public function images()
    {
        return $this->hasMany(CarImage::class);
    }
}
