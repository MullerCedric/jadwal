<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    protected $fillable = [
        'teacher_id', 'exam_session_id', 'values', 'about', 'is_validated', 'sent_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'sent_at'
    ];

    protected $casts = [
        'is_validated' => 'boolean',
    ];

    public function teacher()
    {
        return $this->belongsTo('App\Teacher');
    }

    public function examSession()
    {
        return $this->belongsTo('App\ExamSession');
    }

    public function getValuesAttribute($value) {
        return json_decode($value);
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
