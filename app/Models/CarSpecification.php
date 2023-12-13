<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarSpecification extends Model
{
    use HasFactory;

    protected $fillable = ['car_id', 'specification_id', 'value'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function specification()
    {
        return $this->belongsTo(Specification::class);
    }
}
