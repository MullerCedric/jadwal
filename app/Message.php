<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'exam_session_id', 'title', 'body', 'state'
    ];

    public function examSession()
    {
        return $this->belongsTo('App\ExamSession');
    }
}
