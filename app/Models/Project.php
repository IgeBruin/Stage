<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('role_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }


    protected $fillable = ['name', 'introduction', 'content', 'start_date'];
}
