<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    protected $fillable = [
        'forming_id',
        'survey_id',
        'survey_questions_id',
    ];

    public function questionAnswer(){
        return $this->belongsTo(SurveyQuestion::class, 'survey_questions_id', 'id');
    }
}
