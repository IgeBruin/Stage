<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    
    protected $fillable = [
        'name',
        'description',
        'deadline',
        'status',
    ];
}
