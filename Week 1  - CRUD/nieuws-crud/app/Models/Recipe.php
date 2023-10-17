<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'recipes';

    protected $fillable = ['user_id', 'title', 'description', 'image' ,'instructions'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredients')
            ->withPivot('quantity', 'unit');
    }
}
