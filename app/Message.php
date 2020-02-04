<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id', 'exam_session_id', 'title', 'body', 'is_validated', 'sent_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'sent_at'
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'exam_session_id' => 'integer',
        'is_validated' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function examSession()
    {
        return $this->belongsTo('App\ExamSession');
    }

    public function isValidated()
    {
        return $this->is_validated;
    }

    public function isSent()
    {
        return $this->sent_at ? $this->sent_at->startOfDay() <= Carbon::now()->startOfDay() : false;
    }
}
