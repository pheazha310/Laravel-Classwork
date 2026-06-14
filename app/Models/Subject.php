<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'description'];

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_class_subjects');
    }
}
