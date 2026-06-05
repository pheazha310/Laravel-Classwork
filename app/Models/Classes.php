<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $fillable = ['name', 'description'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_classes');
    }

    public function terms()
    {
        return $this->belongsToMany(Term::class, 'add_class_to_terms');
    }
}
