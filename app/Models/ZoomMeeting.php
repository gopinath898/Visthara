<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ZoomMeeting extends Model
{
    protected $table = 'zoom_meetings';

    const STATUS_AWAITED = 1;
    const STATUS_FINISHED = 2;

    const status = [
        self::STATUS_AWAITED => 'Awaited',
        self::STATUS_FINISHED => 'Finished',
    ];

    protected $appends = ['status_text'];

    protected $fillable = [
        'appointment_id',
        'topic',
        'start_time',
        'duration',
        'host_video',
        'participant_video',
        'agenda',
        'created_by',
        'status',
        'meta',
        'meeting_id',
        'time_zone',
        'password',
        'sessionId'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'zoom_meeting_candidates', 'meeting_id', 'user_id');
    }

    public static $rules = [
        'topic'             => 'required',
        'start_time'        => 'required',
        'duration'          => 'required',
        'host_video'        => 'required',
        'participant_video' => 'required',
        'members'           => 'required|array',
        'agenda'            => 'required',

    ];

    /**
     * @return string
     */
    public function getStatusTextAttribute()
    {
        return self::status[$this->status];
    }
}
