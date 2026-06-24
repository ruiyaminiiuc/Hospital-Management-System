<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'description'];

    // Relationship: A department has many doctors (Users)
    public function doctors()
    {
        return $this->hasMany(User::class, 'department_id');
    }
}