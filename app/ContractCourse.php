<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractCourse extends Model
{

    protected $table = 'contract_course';

    protected $fillable = [
        'contract_id',
        'course_id',
    ];

}
