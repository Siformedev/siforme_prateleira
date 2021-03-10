<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        "name",
        "institution",
        "conclusion_year",
        "conclusion_month",
        "signature_date",
        "birthday_date",
        "igpm",
        "email",
        "code",
        "valid",
        "pseg_acc",
        "goal",
        "periodos",
    ];


    public function courses()
    {
        return $this->belongsToMany(Course::class, 'contract_course', 'contract_id', 'course_id');
    }

    public function informativos()
    {
        return $this->hasMany(Informativo::class, 'contract_id', 'id');
    }
    public function formings()
    {
        return $this->hasMany(Forming::class, 'contract_id', 'id');
    }

    public function registers()
    {
        return $this->hasMany(Register::class, 'contract_id', 'id');
    }

    public function expenses()
    {
        return $this->hasMany(ContractExpenses::class, 'contract_id', 'id');
    }

    public function pseg_acc()
    {
        return $this->hasMany(AccountPseg::class, 'id','pseg_acc');
    }
}
