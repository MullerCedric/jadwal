<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class LocationTeacher extends Pivot
{
    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Teacher');
    }

    public function examSessions()
    {
        return $this->hasManyThrough('App\ExamSession', 'App\Location');
    }
}
