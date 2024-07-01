<?php

namespace App\Models;
use App\Traits\Filterable;

class Todo extends BaseModel
{
    use Filterable;
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'category_id',
        'completed',
        'priority',
        'due_date',
        'parent_id',
    ];

    public function subtasks()
    {
        return $this->hasMany(Todo::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Todo::class, 'parent_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($todo) {
            $todo->subtasks()->delete();
        });
    }
}
