<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentSessions extends Model
{
    use HasFactory;

    protected $table = 'appointment_sessions';

    protected $fillable = ['appointment_id','session_name','session_status','session_date','session_timeslot','doctor_id','cancel_by','cancel_reason'];

    public function zoomSessions()
    {
        return $this->belongsTo('App\Models\ZoomMeeting','id','sessionid')->orderby('zoom_meetings.created_at','DESC');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor','doctor_id','id')->withTrashed();
    }

    public function appointment()
    {
        return $this->belongsTo('App\Models\Appointment','appointment_id','appointment_id');
    }
}