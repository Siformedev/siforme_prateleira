<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

    protected $table = 'courses';

    protected $fillable = [
        'name',
        'status',
    ];

    public function contracts()
    {
        return $this->belongsToMany(Contract::class, 'contract_course', 'course_id', 'contract_id');
    }
}
