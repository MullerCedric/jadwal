<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamSession extends Model
{
    protected $fillable = [
        'user_id', 'location_id', 'title', 'slug', 'indications', 'deadline', 'state'
    ];

    public function author()
    {
        return $this->belongsTo('App\User');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    public function preferences()
    {
        return $this->hasMany('App\Preference');
    }
}
