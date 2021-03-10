<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    protected $fillable = [
        'name',
        'cpf',
        'department',
        'nivel',
        'status',
        'img',
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
