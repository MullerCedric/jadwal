<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'name', 'email', 'token'
    ];

    protected $hidden = [
        'token'
    ];

    public function locations()
    {
        return $this->belongsToMany('App\Location')->using('App\LocationTeacher');
    }

    public function preferences()
    {
        return $this->hasMany('App\Preference');
    }

    public function examSessions()
    {
        return $this->hasManyThrough(
            'App\ExamSession',          // The model to access to
            'App\LocationTeacher', // The intermediate table
            'teacher_id',                 // The column of the intermediate table that connects to this model by its ID.
            'location_id',              // The column of the intermediate table that connects the Podcast by its ID.
            'id',                      // The column that connects this model with the intermediate model table.
            'location_id'               // The column of the distant table that ties it to the Podcast.
        );
    }
}
