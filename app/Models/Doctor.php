<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;
use App\Models\WorkingHour;
use Carbon\Carbon;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'doctor';

    protected $fillable = ['name','is_filled','treatment_id','category_id','custom_timeslot','dob','gender','expertise_id','timeslot','start_time','end_time','hospital_id','image','user_id','desc','education','certificate','appointment_fees','experience_details','since','status','based_on','commission_amount','is_popular','subscription_status','language','license','cv_image','id_proof','address','city','state','country','designation','title','firstName','middleName','lastName'];

    protected $appends = ['fullImage','rate','review','CV','IdDocument'];

    protected function getFullImageAttribute()
    {
        return url('images/upload').'/'.$this->image;
    }

    public function expertise()
    {
        return $this->belongsTo('App\Models\Expertise');
    }

    public function treatment()
    {
        return $this->belongsTo('App\Models\Treatments');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function DoctorSubscription()
    {
        return $this->hasOne('App\Models\DoctorSubscription');
    }

    public function Doctor()
    {
        return $this->hasOne('App\Models\Doctor');
    }

    // public function user()
    // {
    //     return $this->belongsTo('App\Models\User');
    // }

    public function getRateAttribute()
    {
        $review = Review::where('doctor_id',$this->attributes['id'])->get();
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
        return Review::where('doctor_id',$this->attributes['id'])->count();
    }


    public function todaytimeSlot()
    {
        // print_r($this->id);die();
        $doctor_id=$this->id;
        $date=date('Y-m-d');
        $doctor = Doctor::find($doctor_id);
        $workingHours = WorkingHour::where('doctor_id',$doctor->id)->get();
        $master = [];
        $timeslot = $doctor->timeslot == 'other' ? $doctor->custom_timeslot : $doctor->timeslot;

        foreach ($workingHours as $hours)
        {
            if($hours->booking_date == $date)
            {
                if($hours->status == 1)
                {
                    foreach (json_decode($hours->period_list) as $value)
                    {
                        $start_time = new Carbon($date . ' ' . $value->start_time);
                        $end_time = new Carbon($date . ' ' . $value->end_time);
                        if ($date == Carbon::now(env('timezone'))->format('Y-m-d')) {
                            $t = Carbon::now(env('timezone'));
                            $minutes = date('i', strtotime($t));
                            if ($minutes <= 30) {
                                $add = 30 - $minutes;
                            } else {
                                $add = 60 - $minutes;
                            }
                            $add += 60;
                            $d = $t->addMinutes($add)->format('h:i a');
                            // $start_time = new Carbon($date . ' ' . $d);

                            $now = new Carbon($date . ' ' . date("h:i a"));

                            if ($start_time <= $now)
                            {
                               
                                // break;
                                continue;
                            }
                            
                        }

                        

                        if ($start_time >= $end_time)
                        {
                            break;
                        }
                        else
                        {
                            $temp['start_time'] = $start_time->format('h:i a');
                            $temp['end_time'] = $end_time->format('h:i a');

                            $time = strval($temp['start_time']);
                            
                            $appointment = Appointment::where([['doctor_id', $doctor_id], ['time', $time], ['date', $date]])->first();

                            if ($appointment)
                            {
                                //
                            } else {
                                array_push($master, $temp);
                            }
                        }
                    }
                }
            }
        }

        if (empty($master)) {
            $temp['start_time'] = 'Today - No Slot';
            $temp['end_time'] = 'No Slot';
            array_push($master, $temp);
        }
        return $master;
    }

    protected function getCVAttribute()
    {
        return url('images/upload').'/'.$this->cv_image;
    }

    protected function getIdDocumentAttribute()
    {
        return url('images/upload').'/'.$this->id_proof;
    }



    public function areaexperties(){

        
        $expertiseArea = TherapistSpecializations::where('doctor_user_id',$this->id)->first();
        $list = Category::whereIn('id', json_decode($expertiseArea->specialisation_id ?? '') ?? [])->get()->pluck('name')->toArray();

        return $list;
            
    }
}
