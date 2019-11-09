<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    protected $fillable = [
        'teacher_id', 'exam_session_id', 'values', 'state'
    ];

    public function author()
    {
        return $this->belongsTo('App\Teacher');
    }

    public function examSession()
    {
        return $this->belongsTo('App\ExamSession');
    }
}
