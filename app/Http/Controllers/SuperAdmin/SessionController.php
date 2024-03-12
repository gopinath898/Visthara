<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\AppointmentSessions;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Setting;
use App\Models\NotificationTemplate;
use App\Http\Controllers\Controller;
use App\Repositories\MeetingRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $meetingRepository;

    /**
     * MeetingController constructor.
    * @param  MeetingRepository  $meetingRepository
    */
    public function __construct(MeetingRepository $meetingRepository)
    {
        $this->meetingRepository = $meetingRepository;
    }

    public function index($appointment_id)
    {
        $appointmentSessions = AppointmentSessions::leftJoin('appointment','appointment_sessions.appointment_id','=','appointment.appointment_id')
        ->where('appointment.id',$appointment_id)
        ->select('appointment_sessions.*', 'appointment.patient_name')->get();

        foreach($appointmentSessions as $appointmentSession){
            if($appointmentSession->zoomSessions){

            $zoomobj = json_decode($appointmentSession->zoomSessions,true);
                $zoomurl = $zoomobj['meta']['start_url'];

            }else{
                $zoomurl='';
            } 
            
            $appointmentSession->zoomurl = $zoomurl;
        }
        return view('superAdmin.appointment.sessions',compact('appointmentSessions'));
    }

    public function completeSession($id){
        $appointmentSession = AppointmentSessions::find($id)->update(['session_status'=>'completed']);
        return redirect()->back()->with('status',__('status change successfully...!!'));
    }

    public function show_sessions($appointment_id)
    {
        $appointmentSessions = AppointmentSessions::leftJoin('appointment','appointment_sessions.appointment_id','=','appointment.appointment_id')
        ->where('appointment.id',$appointment_id)
        ->select('appointment_sessions.*', 'appointment.doctor_id')->get();

        foreach($appointmentSessions as $appointmentSession){
            if($appointmentSession->zoomSessions){

                $zoomobj = json_decode($appointmentSession->zoomSessions,true);
                $zoomurl = $zoomobj['meta']['start_url'];

            }else{
                $zoomurl='';
            } 
            
            $appointmentSession->zoomurl = $zoomurl;
        }        
        return response(['success' => true , 'data' => $appointmentSessions]);
    }

    public function bookSession(Request $request)
    {
        $doctor = Doctor::find($request->doctor_id);

        if(!$doctor){
            return redirect()->back()->withErrors('Please choose therapist.');
        }

        $doctoruser = User::find($doctor->user_id);

        $request->merge(['topic'=>'Myminddoctor Appointment',
            'start_time'=>$request->date.' '.$request->time,
            'duration'=>30,
            'agenda'=> 'Appointment with Therapist',
            'host_video'=>1,
            'appointment_id' => $request->appointment_id,
            'participant_video'=>1,
            'therapist_email' => $doctoruser->email,
            'therapist_name' =>  $doctoruser->name,
            'members' => [$request->doctor_id,auth()->user()->id],
            'time_zone' => 'Asia/Singapore',
            'sessionId' => $request->id
            ]
        );
        $zoomdata = $this->meetingRepository->store($request->all());

        $appointmentSession = AppointmentSessions::find($request->id);
        $appointmentSession->update(['session_timeslot'=>$request->time, 'session_date'=>$request->date, 'session_status'=>'booked', 'doctor_id'=>$request->doctor_id]);

        if($appointmentSession->zoomSessions){

            $zoomobj = json_decode($appointmentSession->zoomSessions,true);
            $zoomurl = $zoomobj['meta']['start_url'];

        }else{
            $zoomurl='';
        } 

        $notification_template = NotificationTemplate::where('title','session booking')->first();
        $notification_template2 = NotificationTemplate::where('title','session booked for therapist')->first();
        
        $detail['user_name'] = auth()->user()->name;
        $detail['therapist_name'] = $doctor->name;
        $detail['appointment_date'] = $appointmentSession->session_date.' '.$appointmentSession->session_timeslot;
        $detail['zoom_link'] = $zoomurl;
        $detail['phone'] = Setting::first()->phone;

        $data = ["{{user_name}}","{{therapist_name}}","{{appointment_date}}","{{zoom_link}}","{{phone}}"];
       
        $message = str_replace($data, $detail, $notification_template->mail_content);
        $message2 = str_replace($data, $detail, $notification_template2->mail_content);

        try {
            Mail::to(auth()->user()->email)->send(new SendMail($message,$notification_template->subject));
            Mail::to($doctoruser->email)->send(new SendMail($message2,$notification_template2->subject));
        } catch (\Throwable $th) {
            //throw $th;
        }

        return redirect()->back()->with('status',__('Session booked successfully...!!'));
    }
}