<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name'
    ];

    public function teachers()
    {
        return $this->belongsToMany('App\Teacher')->using('App\LocationTeacher');
    }

    public function examSessions()
    {
        return $this->hasMany('App\ExamSession');
    }
}
