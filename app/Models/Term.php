<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $fillable = ['name', 'generation_id'];

    public function generation()
    {
        return $this->belongsTo(Generation::class);
    }

    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'add_class_to_terms');
    }
}
