<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends BaseModel
{

    protected $fillable = [
        'name',
        'description',
        'status',
    ];
    
    public function todos()
    {
        return $this->hasMany(Todo::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id')
            ->withTimestamps();
    }
}
