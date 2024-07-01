<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($todo) {
            $todo->user_id = auth()->id();
        });
    }
}