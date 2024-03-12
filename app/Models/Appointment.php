<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'appointment';

    protected $fillable = ['user_id','appointment_id','hospital_id','doctor_id','cancel_by','cancel_reason','payment_status','amount','payment_type','appointment_for','patient_name','age','report_image','drug_effect','patient_address','phone_no','date','time','payment_token','appointment_status','illness_information','note','doctor_commission','admin_commission','discount_id','discount_price','package_id','payment_id','payment_order_id','guardian_name','guardian_phone','illness_information_taken','illness_exists'];

    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor')->withTrashed();
    }


    public function totalsessions()
    {
        return $this->hasMany('App\Models\AppointmentSessions','appointment_id','appointment_id')->count();
    }

    public function pendingsessions()
    {
        return $this->hasMany('App\Models\AppointmentSessions','appointment_id','appointment_id')->where('session_status','pending')->count();
    }

    

    public function user()
    {
        return $this->belongsTo('App\Models\User')->withTrashed();
    }

    public function zoom()
    {
        return $this->belongsTo('App\Models\ZoomMeeting','id','appointment_id');
    }

    public function hospital()
    {
        return $this->belongsTo('App\Models\Hospital');
    }


    public function package()
    {
        return $this->belongsTo('App\Models\Subscription','package_id','id');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\UserAddress','patient_address','id');
    }

    protected $appends = ['rate','review'];

    public function getreportImageAttribute()
    {
        if($this->attributes['report_image'] != null)
        {
            $images = array();
            $image = json_decode($this->attributes['report_image']);
            for ($i=0; $i < count($image); $i++)
            {
                array_push($images,url('images/upload').'/'.$image[$i]);
            }
            return $images;
        }
        else
        {
            return [];
        }
    }

    public function getRateAttribute()
    {
        $review = Review::where('appointment_id',$this->attributes['id'])->get();
        if (count($review) > 0) {
            $totalRate = 0;
            foreach ($review as $r)
            {
                $totalRate = $totalRate + $r->rate;
            }
            return round($totalRate / count($review), 1);
        }
        else
        {
            return 0;
        }
    }

    public function getReviewAttribute()
    {
        return Review::where('appointment_id',$this->attributes['id'])->count();
    }
}
