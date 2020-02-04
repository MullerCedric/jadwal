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

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'location_id' => 'integer',
        'is_validated' => 'boolean',
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

    public function scopeOfType($q, $type = 'basic')
    {
        $today = Carbon::now()->startOfDay();

        if ($type !== 'hot') {
            return $q->basic();
        }

        return $q->hot();
    }

    public function scopeBasic($q)
    {
        $today = Carbon::now()->startOfDay();

        return $q->whereDate('deadline', '>', $today)
            ->orWhere(function ($q) use ($today) {
                $q->where('is_validated', false)
                    ->orWhereNull('sent_at')
                    ->orWhereDate('sent_at', '>', $today);
            });
    }

    public function scopeHot($q)
    {
        $today = Carbon::now()->startOfDay();

        return $q->whereDate('deadline', '<=', $today)
            ->where('is_validated', true)
            ->whereDate('sent_at', '<=', $today);
    }

    public function isValidated()
    {
        return $this->is_validated;
    }

    public function isSent()
    {
        return $this->sent_at ? $this->sent_at->startOfDay() <= Carbon::now()->startOfDay() : false;
    }

    public function percent()
    {
        return floor($this->sent_preferences_count / $this->location->teachers->count() * 100);
    }
}
