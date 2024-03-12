<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Category;
use App\Models\Country;
use App\Models\Doctor;
use App\Models\DoctorSubscription;
use App\Models\Expertise;
use App\Models\Hospital;
use App\Models\Offer;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Settle;
use App\Models\Subscription;
use App\Models\Treatments;
use App\Models\User;
use App\Models\WorkingHour;
use App\Models\TherapistExpertise;
use App\Models\TherapistSpecializations;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Mail\SendMail;
use Mail;
use Illuminate\Support\Facades\Auth;


class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('doctor_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $doctors = Doctor::with('expertise')->orderBy('id','desc')->get();
        foreach ($doctors as $doctor) {
            $doctor->user = User::find($doctor->user_id);
        }
        $activePage = 'doctor';
        return view('superAdmin.doctor.doctor',compact('doctors','activePage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('doctor_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $countries = Country::get();
        $treatments = Treatments::whereStatus(1)->get();
        $treat = [];
        $categories = [];
        $expertieses = [];

        $languages = Language::all();
        $treat = Treatments::whereStatus(1)->first();
        if($treat){
            $categories = Category::whereStatus(1)->where('treatment_id',$treat->id)->get();
            $cat = Category::whereStatus(1)->where('treatment_id',$treat->id)->first();
            if($cat){
                $expertieses = Treatments::whereStatus(1)->get();
            }
        }
        $hospitals = Hospital::whereStatus(1)->get();
        return view('superAdmin.doctor.create_doctor',compact('countries','treatments','hospitals','categories','expertieses','languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|unique:doctor',
            'email' => 'bail|required|email|unique:users',
            'treatment_id' => 'bail|required',
            'category_id' => 'bail|required',
            'dob' => 'bail|required',
            'gender' => 'bail|required',
            'phone' => 'bail|required|digits_between:6,12',
            // 'expertise_id' => 'bail|required',
            'timeslot' => 'bail|required',
            'start_time' => 'bail|required',
            'end_time' => 'bail|required|after:start_time',
            'desc' => 'required',
            'custom_timeslot' => 'bail|required_if:timeslot,other',
            'commission_amount' => 'bail|required_if:based_on,commission'
        ]);
        $data = $request->all();
        
        $password = mt_rand(100000,999999);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($password),
            'verify' => 1,
            'phone' => $data['phone'],
            'phone_code' => $data['phone_code'],
            'image' => 'defaultUser.png'
        ],
        [
            'image.max' => 'The Image May Not Be Greater Than 1 MegaBytes.',
        ]);
        
        $message1 = 'Dear Therapist your password is : '.$password;
        try
        {
            Mail::to($user->email)->send(new SendMail($message1,'Therapist Password'));
        }
        catch (\Throwable $th)
        {

        }
        $user->assignRole('Therapist');
        // $user = User::find(50);
        $data['user_id'] = $user->id;
        $data['start_time'] = strtolower(Carbon::parse($data['start_time'])->format('h:i a'));
        $data['end_time'] = strtolower(Carbon::parse($data['end_time'])->format('h:i a'));
        if($request->hasFile('image'))
        {
            $data['image'] = (new CustomController)->imageUpload($request->image);
        }
        else
        {
            $data['image'] = 'defaultUser.png';
        }
        $education = array();
        for ($i=0; $i < count($data['degree']); $i++)
        {
            $temp['degree'] = $data['degree'][$i];
            $temp['college'] = $data['college'][$i];
            $temp['year'] = $data['year'][$i];
            array_push($education,$temp);
        }
        $data['education'] = json_encode($education);

        $license = array();
        for ($i=0; $i < count($data['licenseName']); $i++)
        {
            $temp1['licenseName'] = $data['licenseName'][$i];
            $temp1['licenseNumber'] = $data['licenseNumber'][$i];
            $temp1['issuedBy'] = $data['issuedBy'][$i];
            $temp1['issueDate'] = $data['issueDate'][$i];
            $temp1['expiryDate'] = $data['expiryDate'][$i];
            array_push($license,$temp1);
        }
        $data['license'] = json_encode($license);

        $certificate = array();
        for ($i=0; $i < count($data['certificate']); $i++)
        {
            $temp2['certificate'] = $data['certificate'][$i];
            $temp2['issuedBy'] = $data['certificate_issuedBy'][$i];
            $temp2['issueDate'] = $data['certificate_issueDate'][$i];
            $temp2['expiryDate'] = $data['certificate_expiryDate'][$i];

            array_push($certificate,$temp2);
        }
        $data['certificate'] = json_encode($certificate);
        
        $experience = array();
        for ($i=0; $i < count($data['experience_years']); $i++)
        {
            $temp3['experience_years'] = $data['experience_years'][$i];
            $temp3['company'] = $data['company'][$i];
            $temp3['job_title'] = $data['job_title'][$i];
            $temp3['duration'] = $data['duration'][$i];
            $temp3['location'] = $data['location'][$i];
            $temp3['description'] = $data['description'][$i];
            array_push($experience,$temp3);
        }
        $data['experience_details'] = json_encode($experience);

        $data['since'] = Carbon::now(env('timezone'))->format('Y-m-d , h:i A');
        $data['status'] = 1;
        $data['subscription_status'] = 1;
        $data['is_filled'] = 1;
        $data['treatment_id'] = $request->treatment_id[0];
        $data['category_id'] = $request->category_id[0];
        $data['language'] = json_encode($request->language);

        $doctor = Doctor::create($data);
        TherapistSpecializations::create(['doctor_user_id'=>$data['user_id'],'specialisation_id'=>json_encode($request->category_id)]);
        TherapistExpertise::create(['doctor_user_id'=>$data['user_id'],'expertise_id'=>json_encode($request->treatment_id)]);

        if($doctor->based_on == 'subscription')
        {
            $subscription = Subscription::where('name','free')->first();
            if($subscription)
            {
                $doctor_subscription['doctor_id'] = $doctor->id;
                $doctor_subscription['subscription_id'] = $subscription->id;
                $doctor_subscription['duration'] = 1;
                $doctor_subscription['start_date'] = Carbon::now(env('timezone'))->format('Y-m-d');
                $doctor_subscription['end_date'] = Carbon::now(env('timezone'))->addMonths(1)->format('Y-m-d');
                $doctor_subscription['status'] = 1;
                $doctor_subscription['payment_status'] = 1;
                DoctorSubscription::create($doctor_subscription);
            }
        }
        $start_time = strtolower($doctor->start_time);
        $end_time = strtolower($doctor->end_time);
        $master = array();
        $temp4['start_time'] = $start_time;
        $temp4['end_time'] = $end_time;
        array_push($master,$temp4);
        $work_time['doctor_id'] = $doctor->id;
        $work_time['period_list'] = json_encode($master);
        $work_time['booking_date'] = date('Y-m-d');
        $work_time['status'] = 1;
        WorkingHour::create($work_time);
        
        return redirect('therapy')->withStatus(__('Doctor created successfully..!!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show($id,$name,$with)
    {
        (new CustomController)->cancel_max_order();
        $doctor = Doctor::with('expertise')->find($id);
        $currency = Setting::first()->currency_symbol;
        if($with == 'dashboard')
        {
            $totalUsers = User::doesntHave('roles')->where('doctor_id',$id)->count();
            $totalAppointments = Appointment::where('doctor_id',$id)->get();
            return view('superAdmin.doctor.show_doctor',compact('doctor','currency','totalUsers','totalAppointments'));
        }
        else if($with == 'appointment')
        {
            return view('superAdmin.doctor.doctor_appointment',compact('doctor'));
        }
        else if($with == 'patients')
        {
            $patients = User::doesntHave('roles')->where('doctor_id',$id)->get();
            return view('superAdmin.doctor.doctor_patients',compact('doctor','patients'));
        }
        else if($with == 'schedule')
        {
            $doctor->workingHours = WorkingHour::where('doctor_id',$id)->get();
            $doctor->firstHours = WorkingHour::where('doctor_id',$id)->first();
            return view('superAdmin.doctor.doctor_schedule',compact('doctor'));
        }
        else if($with == 'finance')
        {
            if($doctor->based_on == 'commission')
            {
                $now = Carbon::today();
                $appointments = array();
                for ($i = 0; $i < 7; $i++)
                {
                    $appointment = Appointment::where('doctor_id',$doctor->id)->whereDate('created_at', $now)->get();
                    $appointment['amount'] = $appointment->sum('amount');
                    $appointment['admin_commission'] = $appointment->sum('admin_commission');
                    $appointment['doctor_commission'] = $appointment->sum('doctor_commission');
                    $now =  $now->subDay();
                    $appointment['date'] = $now->toDateString();
                    array_push($appointments,$appointment);
                }

                $past = Carbon::now(env('timezone'))->subDays(35);
                $now = Carbon::today();
                $c = $now->diffInDays($past);
                $loop = $c / 10;
                $data = [];
                while ($now->greaterThan($past)) {
                    $t = $past->copy();
                    $t->addDay();
                    $temp['start'] = $t->toDateString();
                    $past->addDays(10);
                    if ($past->greaterThan($now)) {
                        $temp['end'] = $now->toDateString();
                    } else {
                        $temp['end'] = $past->toDateString();
                    }
                    array_push($data, $temp);
                }

                $settels = array();
                $orderIds = array();
                foreach ($data as $key)
                {
                    $settle = Settle::where('doctor_id', $doctor->id)->where('created_at', '>=', $key['start'].' 00.00.00')->where('created_at', '<=', $key['end'].' 23.59.59')->get();
                    $value['d_total_task'] = $settle->count();
                    $value['admin_earning'] = $settle->sum('admin_amount');
                    $value['doctor_earning'] = $settle->sum('doctor_amount');
                    $value['d_total_amount'] = $value['admin_earning'] + $value['doctor_earning'];
                    $remainingOnline = Settle::where([['doctor_id', $doctor->id], ['payment', 0],['doctor_status', 0]])->where('created_at', '>=', $key['start'].' 00.00.00')->where('created_at', '<=', $key['end'].' 23.59.59')->get();
                    $remainingOffline = Settle::where([['doctor_id', $doctor->id], ['payment', 1],['doctor_status', 0]])->where('created_at', '>=', $key['start'].' 00.00.00')->where('created_at', '<=', $key['end'].' 23.59.59')->get();

                    $online = $remainingOnline->sum('doctor_amount'); // admin e devana
                    $offline = $remainingOffline->sum('admin_amount'); // admin e levana

                    $value['duration'] = $key['start'] . ' - ' . $key['end'];
                    $value['d_balance'] = $offline - $online; // + hoy to levana - devana
                    array_push($settels,$value);
                }
                return view('superAdmin.doctor.finance',compact('doctor', 'appointments', 'currency','settels'));
            }
            if($doctor->based_on == 'subscription')
            {
                $subscriptions = DoctorSubscription::with(['Subscription','doctor'])->where('doctor_id',$id)->orderBy('id','DESC')->get();
                return view('superAdmin.doctor.finance',compact('doctor','subscriptions','currency'));
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('doctor_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $doctor = Doctor::find($id);
        $doctor->user = User::find($doctor->user_id);
        $countries = Country::get();
        $treatments = Treatments::whereStatus(1)->get();
        $categories = Category::whereStatus(1)->get();
        $expertises = TherapistExpertise::where('doctor_user_id',$doctor->user_id)->first();
        $specializations = TherapistSpecializations::where('doctor_user_id',$doctor->user_id)->first();
        $hospitals = Hospital::get();

        $languages = Language::all();
        
        $doctor['start_time'] = Carbon::parse($doctor['start_time'])->format('H:i');
        $doctor['end_time'] = Carbon::parse($doctor['end_time'])->format('H:i');
        $doctor['hospital_id'] = explode(',',$doctor->hospital_id);
        $cv_type = explode('.',$doctor->cv_image);
        $doctor['cv_type'] = $cv_type[1] ?? '';
        $fullName = explode(' ', $doctor->name);
        $doctor['firstName'] = $doctor->firstName ?? $fullName[0] ?? '';
        $doctor['middleName'] = $doctor->middleName ?? $fullName[1] ?? '';
        $doctor['lastName'] = $doctor->lastName ?? $fullName[2] ?? '';
        return view('superAdmin.doctor.edit_doctor',compact('doctor','countries','treatments','hospitals','categories','expertises','languages','specializations'));
    }


    public function myprofile(Request $request)
    {
        $doctor = Doctor::where('user_id','=',auth()->user()->id)->first();

        $languages = Language::all();
        $doctor->user = User::find($doctor->user_id);
        $countries = Country::get();
        $treatments = Treatments::whereStatus(1)->get();
        $categories = Category::whereStatus(1)->get();
        $expertises = TherapistExpertise::where('doctor_user_id',$doctor->user_id)->first();
        $specializations = TherapistSpecializations::where('doctor_user_id',$doctor->user_id)->first();
        $hospitals = Hospital::get();
        $doctor['start_time'] = Carbon::parse($doctor['start_time'])->format('H:i');
        $doctor['end_time'] = Carbon::parse($doctor['end_time'])->format('H:i');
        $doctor['hospital_id'] = explode(',',$doctor->hospital_id);
        $cv_type = explode('.',$doctor->cv_image);
        $doctor['cv_type'] = $cv_type[1] ?? '';
        $fullName = explode(' ', $doctor->name);
        $doctor['firstName'] = $doctor->firstName ?? $fullName[0] ?? '';
        $doctor['middleName'] = $doctor->middleName ?? $fullName[1] ?? '';
        $doctor['lastName'] = $doctor->lastName ?? $fullName[2] ?? '';
        return view('superAdmin.doctor.edit_doctor',compact('doctor','countries','treatments','hospitals','categories','expertises','languages','specializations'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->merge([
            'name' => $request->firstName.' '.$request->middleName.' '.$request->lastName
        ]);
        $request->validate([
            'name' => 'bail|required|unique:doctor,name,' . $id . ',id',
            'treatment_id' => 'bail|required',
            'category_id' => 'bail|required',
            'dob' => 'bail|required',
            'gender' => 'bail|required',
            'phone' => 'bail|required|digits_between:6,12',
            'desc' => 'required',
            'image' => 'bail|max:1000',
            'custom_timeslot' => 'bail|required_if:timeslot,other',
            'commission_amount' => 'bail|required_if:based_on,commission'
        ],
        [
            'image.max' => 'The Image May Not Be Greater Than 1 MegaBytes.',
        ]);
        $doctor = Doctor::find($id);
        $data = $request->all();

        if($request->hasFile('image'))
        {
            (new CustomController)->deleteFile($doctor->image);
            $data['image'] = (new CustomController)->imageUpload($request->image);
        }
        if($request->hasFile('cv_image'))
        {
            (new CustomController)->deleteFile($doctor->cv_image);
            $data['cv_image'] = (new CustomController)->imageUpload($request->cv_image);
        }
        if($request->hasFile('id_proof'))
        {
            (new CustomController)->deleteFile($doctor->id_proof);
            $data['id_proof'] = (new CustomController)->imageUpload($request->id_proof);
        }
        $education = array();
        for ($i=0; $i < count($data['degree']); $i++)
        {
            $temp['degree'] = $data['degree'][$i];
            $temp['college'] = $data['college'][$i];
            $temp['year'] = $data['year'][$i];
            
            if($request->hasFile('degree_'.$i+1))
            {
                $deleteImage = $data['degreeFile'][$i] ?? '';
                (new CustomController)->deleteFile($deleteImage);
                $temp['degreeFile'] = (new CustomController)->imageUpload($data['degree_'.$i+1]);
            }
            else{
                $temp['degreeFile'] = $data['degreeFile'][$i] ?? '';
            }
            array_push($education,$temp);
        }
        $data['education'] = json_encode($education);

        $license = array();
        for ($i=0; $i < count($data['licenseName']); $i++)
        {
            $temp1['licenseName'] = $data['licenseName'][$i];
            $temp1['licenseNumber'] = $data['licenseNumber'][$i];
            $temp1['issuedBy'] = $data['issuedBy'][$i];
            $temp1['issueDate'] = $data['issueDate'][$i];
            $temp1['expiryDate'] = $data['expiryDate'][$i];
             
            if($request->hasFile('license_'.$i+1))
            {
                $deleteImage = $data['licenseFile'][$i] ?? '';
                (new CustomController)->deleteFile($deleteImage);
                $temp1['licenseFile'] = (new CustomController)->imageUpload($data['license_'.$i+1]);
            }
            else{
                $temp1['licenseFile'] = $data['licenseFile'][$i] ?? '';
            }
            array_push($license,$temp1);
        }
        $data['license'] = json_encode($license);

        $certificate = array();
        for ($i=0; $i < count($data['certificate']); $i++)
        {
            $temp2['certificate'] = $data['certificate'][$i];
            $temp2['issuedBy'] = $data['certificate_issuedBy'][$i];
            $temp2['issueDate'] = $data['certificate_issueDate'][$i];
            $temp2['expiryDate'] = $data['certificate_expiryDate'][$i];
             
            if($request->hasFile('certificate_'.$i+1))
            {
                $deleteImage = $data['certificateFile'][$i] ?? '';
                (new CustomController)->deleteFile($deleteImage);
                $temp2['certificateFile'] = (new CustomController)->imageUpload($data['certificate_'.$i+1]);
            }
            else{
                $temp2['certificateFile'] = $data['certificateFile'][$i] ?? '';
            }
            array_push($certificate,$temp2);
        }
        $data['certificate'] = json_encode($certificate);

        $experience = array();
        for ($i=0; $i < count($data['experience_years']); $i++)
        {
            $temp3['experience_years'] = $data['experience_years'][$i];
            $temp3['company'] = $data['company'][$i];
            $temp3['job_title'] = $data['job_title'][$i];
            $temp3['duration'] = $data['duration'][$i];
            $temp3['location'] = $data['location'][$i];
            $temp3['description'] = $data['description'][$i];
            array_push($experience,$temp3);
        }
        $data['experience_details'] = json_encode($experience);

        $userloged = Auth::user()->load('roles');

        if($userloged->hasRole('Therapist')){
            $data['is_filled'] = 0;
        }else{
           $data['is_filled'] = 1; 
        }
        
        $data['language'] = json_encode($request->language);
        $data['custom_timeslot'] = $request->custom_time == '' ? null : $request->custom_time;
        $data['treatment_id'] = $request->treatment_id[0];
        $data['category_id'] = $request->category_id[0];
        $doctor->update($data);

        $expertises = TherapistExpertise::where('doctor_user_id',$doctor->user_id);
        $specializations = TherapistSpecializations::where('doctor_user_id',$doctor->user_id);
        $expertises->updateOrCreate(['doctor_user_id'=>$doctor->user_id],['expertise_id'=>json_encode($request->treatment_id)]);
        $specializations->updateOrCreate(['doctor_user_id'=>$doctor->user_id],['specialisation_id'=>json_encode($request->category_id)]);

        if(Gate::denies('doctor_edit')){
            return redirect()->back()->withStatus(__('Therapist updated successfully..!!'));
        }
        return redirect('therapy')->withStatus(__('Therapist updated successfully..!!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('doctor_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $offers = Offer::all();
        foreach ($offers as $value)
        {
            $doctor_id = explode(',',$value['doctor_id']);
            if (($key = array_search($id, $doctor_id)) !== false)
            {
                return response(['success' => false , 'data' => 'This doctor connected with Offer first delete Offer']);
            }
        }
        $id = Doctor::find($id);
        $user = User::find($id->user_id);
        $user->removeRole('Therapist');
        $user->delete();
        (new CustomController)->deleteFile($id->image);
        $id->delete();
        return response(['success' => true]);
    }

    public function display_timeslot($doctor_id,$date)
    {
        $work = WorkingHour::where('doctor_id',$doctor_id)->where('booking_date',$date)->first();
        return response(['success' => true , 'data' => $work]);
    }

    public function edit_timeslot($id)
    {
        $work = WorkingHour::find($id);
        return response(['success' => true , 'data' => $work]);
    }

    public function update_timeslot(Request $request)
    {
        $data = $request->all();
        $work = WorkingHour::find($request->working_id);
        $master = array();

        if($request->has('start_time')){
            for ($i=0; $i < count($request->start_time); $i++)
            {
                $temp['start_time'] = strtolower($request->start_time[$i]);
                $temp['end_time'] = strtolower($request->end_time[$i]);
                array_push($master,$temp);
            }
            $data['period_list'] = json_encode($master);
            $data['status'] = $request->has('status') ? 1 : 0;
            $work->update($data);
        }
        else{
            $work->delete();
        }
        return redirect()->back();
    }

    public function change_password(Request $request)
    {
        $request->validate([
            'new_password' => 'bail|required|min:6',
            'confirm_new_password' => 'bail|required|min:6|same:new_password'
        ]);
        User::find(Doctor::find($request->doctor_id)->user_id)->update(['password' => Hash::make($request->new_password)]);
        return redirect()->back()->withStatus(__('password change successfully..!!'));
    }

    public function change_status(Request $reqeust)
    {
        $doctor = Doctor::find($reqeust->id);
        $data['status'] = $doctor->status == 1 ? 0 : 1;
        $doctor->update($data);
        return response(['success' => true]);
    }

    public function create_timeslot(Request $request)
    {
        $data = $request->all();

        if($request->working_doctor_id){
            $doctor_id = $request->working_doctor_id;
        }
        else{
            if(auth()->user()->hasRole('super admin')){
                $doctor = Doctor::where('user_id',$request->working_doctor_user_id)->first();
            }
            else{
                $doctor = Doctor::where('user_id',auth()->user()->id)->first();
            }
            $doctor_id = $doctor->id;
        }
        $work = WorkingHour::where('doctor_id',$doctor_id)->where('booking_date',$request->booking_date)->first();
        $master = array();
        for ($i=0; $i < count($request->start_time); $i++)
        {
            $temp['start_time'] = strtolower($request->start_time[$i]);
            $temp['end_time'] = strtolower($request->end_time[$i]);
            array_push($master,$temp);
        }
        $data['period_list'] = json_encode($master);
        $date = $request->booking_date;
        $data['status'] = $request->has('status') ? 1 : 0;
        $dayname = Carbon::parse($date)->format('l');

        WorkingHour::updateOrCreate(['doctor_id'=>$doctor_id, 'booking_date'=>$request->booking_date],['period_list'=>$data['period_list'], 'status'=>$data['status'], 'day_index'=>$dayname]);
        return redirect()->back();
    }

    public function showTherapistToSchedule()
    {
        $doctors = Doctor::with('expertise')->orderBy('id','desc')->get();
        foreach ($doctors as $doctor) {
            $doctor->user = User::find($doctor->user_id);
        }
        $activePage = 'schedule';
        return view('superAdmin.doctor.doctor',compact('doctors','activePage'));
    }
}
