<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamSession extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'location_id', 'title', 'slug', 'indications', 'deadline', 'is_validated', 'sent_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'sent_at',
        'deadline'
    ];

    public function user()
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

    public function isValidated()
    {
        return $this->is_validated;
    }

    public function isSent()
    {
        return $this->sent_at ? $this->sent_at->startOfDay() <= Carbon::now()->startOfDay() : false;
    }
}
