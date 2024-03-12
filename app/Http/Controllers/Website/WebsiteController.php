<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SuperAdmin\CustomController;
use App\Models\Appointment;
use App\Models\Banner;
use App\Repositories\MeetingRepository;
use App\Models\Category;
use App\Models\Doctor;
use App\Models\Faviroute;
use App\Models\Hospital;
use App\Models\Review;
use App\Models\Setting;
use App\Models\AppointmentSessions;
use App\Models\AppointmentDocument;
use App\Models\Treatments;
use App\Models\TherapistSpecializations;
use App\Models\TherapistExpertise;
use App\Models\HospitalGallery;
use App\Models\Language;
use App\Models\ReportData;
use App\Models\User;
use App\Models\Pharmacy;
use App\Models\PharmacyWorkingHour;
use App\Models\UserAddress;
use App\Models\WorkingHour;
use App\Models\Subscription;
use App\Models\NotificationTemplate;
use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use App;
use App\Mail\SendMail;
use App\Models\Blog;
use App\Models\DoctorSubscription;
use App\Models\Lab;
use App\Models\LabSettle;
use App\Models\LabWorkHours;
use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Models\MedicineChild;
use App\Models\Pathology;
use App\Models\PathologyCategory;
use App\Models\PharmacySettle;
use App\Models\Prescription;
use App\Models\PurchaseMedicine;
use App\Models\Radiology;
use App\Models\RadiologyCategory;
use App\Models\FaqCategory;
use App\Models\Report;
use Illuminate\Support\Facades\Mail;
use Str;
use Illuminate\Support\Facades\DB;
use Log;
use PDF;
use DateTime;

class WebsiteController extends Controller
{

    private $meetingRepository;

    /**
     * MeetingController constructor.
     * @param  MeetingRepository  $meetingRepository
     */
    public function __construct(MeetingRepository $meetingRepository)
    {
        $this->meetingRepository = $meetingRepository;
    }

    public function home()
    {
        if (env('DB_DATABASE') == '') {
            return view('first_page');
        } else {
            $banners = Banner::get();
            $treatments = Treatments::whereStatus(1)->orderBy('order_by')->get()->take(5);
            $setting = Setting::find(1);
            $reviews = Review::with('user')->where('status', 'approved')->orderBy('id', 'DESC')->get()->take(9);
            $doctors = Doctor::with('category:id,name')->where([['status', 1], ['is_filled', 1], ['subscription_status', 1]])->get()->take(8);
            foreach ($doctors as $doctor) {
                $doctor->total_appointment = Appointment::where('doctor_id', $doctor->id)->count();
                $expertiseArea = TherapistSpecializations::where('doctor_user_id', $doctor->user_id)->first();
                $doctor->expertiseArea = Category::whereIn('id', json_decode($expertiseArea->specialisation_id ?? '') ?? [])->get()->pluck('name')->toArray();
                $doctor->language = Language::whereIn('id', json_decode($doctor->language ?? '') ?? [])->get()->pluck('name')->toArray();
            }


            foreach ($doctors as &$dd) {
                $dd['is_fav'] = $this->checkFavourite($dd['id']);
                $dd->hospital = (new CustomController)->getHospital($dd['id']);

                $dd['todaytimeSlot'] = $dd->todaytimeSlot();
            }
            $blogs = Blog::where([['status', 1], ['release_now', 1]])->orderBy('id', 'DESC')->get();

            $categories = Category::whereStatus(1)->orderBy('order_by')->get()->take(5);


            $iqra = Doctor::with('category:id,name')->where('id', 22)->first();
            

            return view('website.home', compact('treatments', 'banners', 'setting', 'reviews', 'doctors', 'categories', 'blogs', 'iqra'));
        }
    }

    public function websubscription()
    {

        $subscriptions = Subscription::orderBy('id', 'DESC')->get()->makeHidden(['created_at', 'updated_at']);

        return view('website.subscription', compact('subscriptions'));
    }


    public function contact()
    {

        $contact = '';

        return view('website.contact', compact('contact'));
    }

    public function how_it_works()
    {
        return view('website.how_it_works');
    }


    public function resources()
    {

        $activepage = "Specializations";
        $treatments = Category::whereStatus(1)->orderBy('order_by')->get();

        return view('website.resourcelist', compact('treatments', 'activepage'));
    }


    public function specializations()
    {

        $activepage = "Specializations";
        $treatments = Category::whereStatus(1)->orderBy('order_by')->get();

        return view('website.treatments', compact('treatments', 'activepage'));
    }


    public function treatments()
    {

        $activepage = "Area of Expertise";
        $treatments = Treatments::whereStatus(1)->orderBy('order_by')->get();

        return view('website.treatments', compact('treatments', 'activepage'));
    }


    public function faq()
    {

        $faqsWithoutCategories = RadiologyCategory::whereStatus(1)->whereNull('category_id')->get();
        $faqCategories = FaqCategory::whereStatus(1)->orderBy('sort_cat', 'ASC')->get();
        return view('website.faq', compact('faqsWithoutCategories', 'faqCategories'));
    }


    public function patient_login(Request $request)
    {
        if ($request->has('email') && $request->has('password')) {
            if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
                $user = Auth::user();
                if (!$user->hasAnyRole(Role::all())) {
                    if ($user->status == 1) {
                        if ($user->verify == 1)
                            return redirect('/');
                        else {
                            Session::put('verified_user', $user);
                            return redirect('send_otp');
                        }
                    } else {
                        Auth::logout();
                        return redirect()->back()->withErrors('You are block by admin please contact admin');
                    }
                } else {
                    Auth::logout();
                    return redirect()->back()->withErrors('Only client can login');
                }
            } else
                return redirect()->back()->with('error', __('Invalid Email Or Password'));
        } else {
            return view('website.login');
        }
    }

    public function pendingsession($userid)
    {

        return AppointmentSessions::with(['doctor', 'appointment'])->leftjoin('appointment', 'appointment.appointment_id', 'appointment_sessions.appointment_id')->where('user_id', $userid)->where('payment_status', 1)->where('session_status', 'pending')->count();
    }

    public function patient_register()
    {
        return view('website.register');
    }

    public function sign_up(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'email' => 'bail|required|email|unique:users',
            'dob' => 'bail|required',
            'gender' => 'bail|required',
            'phone' => 'bail|required|numeric|digits_between:6,12',
            'password' => 'bail|required|min:6'
        ]);
        $data = $request->all();
        $verification = Setting::first()->verification;
        $verify = $verification == 1 ? 0 : 1;
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($request->password),
            'verify' => $verify,
            'phone' => $data['phone'],
            'phone_code' => $data['phone_code'],
            'image' => 'defaultUser.png',
            'status' => 1,
            'dob' => $data['dob'],
            'gender' => $data['gender'],
            't&c_checked' => $data['t&c_checked'] ?? 0
        ]);

        $notification_template = NotificationTemplate::where('title', 'sign up')->first();

        $setting = Setting::first();

        $detail['email'] = $setting->email;
        $detail['phone'] = $setting->phone;

        try {
            $data = ["{{email}}", "{{phone}}"];

            $message = str_replace($data, $detail, $notification_template->mail_content);
            \Log::info($message);
            Mail::to($user->email)->send(new SendMail($message, $notification_template->subject));
        } catch (\Throwable $th) {
            //throw $th;
        }

        if ($user->verify == 1) {
            if (Auth::attempt(['email' => $user['email'], 'password' => $request->password]))
                return redirect('/');
        } else {
            Session::put('verified_user', $user);
            return redirect('send_otp');
        }
    }

    public function send_otp()
    {
        $user = Session::get('verified_user');
        (new CustomController)->sendOtp($user);
        $status = '';
        if (Setting::first()->using_msg == 1 && Setting::first()->using_mail == 1)
            $status = 'verification code sent in email and phone';

        if ($status == '') {
            if (Setting::first()->using_msg == 1 || Setting::first()->using_mail == 1) {
                if (Setting::first()->using_msg == 1)
                    $status = 'verification code sent into phone';
                if (Setting::first()->using_mail == 1)
                    $status = 'verification code sent into email';
            }
        }
        return view('website.send_otp', compact('user', 'status'));
    }

    public function verify_user(Request $request)
    {
        $data = $request->all();
        $otp = $data['digit_1'] . $data['digit_2'] . $data['digit_3'] . $data['digit_4'];
        $user = Session::get('verified_user');
        if ($user) {
            if ($user->otp == $otp) {
                $user->verify = 1;
                $user->save();
                if (Auth::loginUsingId($user->id)) {
                    session()->forget('verified_user');
                    return redirect('/');
                }
            } else
                return redirect()->back()->withErrors(__('otp does not match'));
        } else
            return redirect()->back()->withErrors(__('Oops...user not found..!!'));
    }

    public function doctor(Request $request)
    {

        if (isset($request->package_id)) {
            $subscriptions = Subscription::find($request->package_id);

            Session::put('package_id', $subscriptions->id);
        } else {
            $subscriptions = '';
        }

        if (isset($request->session_id)) {

            $sessiondetail = AppointmentSessions::find($request->session_id);
            if (isset($sessiondetail->id) && !empty($sessiondetail->session_timeslot)) {
                $datetime1 = new DateTime();
                $datetime2 = new DateTime($sessiondetail->session_date . ' ' . $sessiondetail->session_timeslot);
                $interval = $datetime1->diff($datetime2);
                $elapsed = $interval->format('%h');

                if ($elapsed < 24) {

                    return redirect()->back()->withErrors(__('You can Reschedule Slot before 24hrs earlier to booked slot'));
                }
            }
        }


        $doctor = Doctor::with(['treatment', 'category', 'expertise'])->whereStatus(1)->where('is_filled', 1);

        $currency = Setting::first()->currency_symbol;
        $categories = Category::whereStatus(1)->get();
        $languages = Language::whereStatus(1)->get();

        $data = $request->all();

        if (isset($data['category'])) {
            $doctor->whereIn('category_id', $data['category']);
            $doctors = $doctor->values()->paginate(9);

            foreach ($doctors as $doctor) {
                $doctor['is_fav'] = $this->checkFavourite($doctor['id']);
                $doctor->hospital = (new CustomController)->getHospital($doctor['id']);
            }
            $view = view('website.doctors', compact('doctors', 'currency', 'categories', 'subscriptions', 'languages'))->render();
            return response()->json(['html' => $view, 'success' => true]);
        }
        if (isset($data['lat']) && isset($data['lang'])) {

            $radius = Setting::first()->radius;
            $hospital = Hospital::whereStatus(1)->GetByDistance($data['lat'], $data['lang'], $radius)->get(['id']);
            $doctor->whereIn('hospital_id', $hospital);
            $doctors = $doctor->values()->paginate(9);
            foreach ($doctors as $doctor) {
                $doctor['is_fav'] = $this->checkFavourite($doctor['id']);
                $doctor->hospital = (new CustomController)->getHospital($doctor['id']);
            }
            $view = view('website.doctors', compact('doctors', 'currency', 'categories', 'subscriptions', 'languages'))->render();
            return response()->json(['html' => $view, 'success' => true]);
        }
        if (isset($data['search_val'])) {

            $doctor->where('name', 'LIKE', '%' . $data['search_val'] . "%");
            $doctors = $doctor->values()->paginate(9);
            foreach ($doctors as $doctor) {
                $doctor['is_fav'] = $this->checkFavourite($doctor['id']);
                $doctor->hospital = (new CustomController)->getHospital($doctor['id']);
            }
            $view = view('website.doctors', compact('doctors', 'currency', 'categories', 'subscriptions', 'languages'))->render();
            return response()->json(['html' => $view, 'success' => true]);
        }
        if (isset($data['gender_type'])) {


            $doctor->where('gender', $data['gender_type']);
            $doctors = $doctor->values()->paginate(9);
            foreach ($doctors as $doctor) {
                $doctor['is_fav'] = $this->checkFavourite($doctor['id']);
                $doctor->hospital = (new CustomController)->getHospital($doctor['id']);
            }
            $view = view('website.doctors', compact('doctors', 'currency', 'categories', 'subscriptions', 'languages'))->render();
            return response()->json(['html' => $view, 'success' => true]);
        }
        if (isset($data['value'])) {


            $doctors = collect($doctor->paginate(9));
            foreach ($doctors as $doctor) {
                $doctor['is_fav'] = $this->checkFavourite($doctor['id']);
                $doctor->hospital = (new CustomController)->getHospital($doctor['id']);
            }
            $reqData = $request->all();
            if ($reqData['value'] == 'rating') {
                $doctors = $doctors->sortByDesc('rate');
            } elseif ($reqData['value'] == 'latest') {
                $doctors = $doctors->sortByDesc('id');
            } elseif ($reqData['value'] == 'popular') {
                $doctors = Doctor::with(['treatment', 'category', 'expertise'])->whereStatus(1)->where('is_filled', 1)->whereSubscriptionStatus(1)->where('is_popular', 1)->get();
                foreach ($doctors as $doctor) {
                    $doctor['is_fav'] = $this->checkFavourite($doctor['id']);
                    $doctor->hospital = (new CustomController)->getHospital($doctor['id']);
                }
            }
            $view = view('website.doctors', compact('doctors', 'currency', 'categories', 'subscriptions', 'languages'))->render();
            return response()->json(['html' => $view, 'success' => true]);
        }
        if (!isset($data['gender_type']) && !isset($data['category']) && !isset($data['value']) && isset($data['from'])) {


            $doctor = Doctor::with(['treatment', 'category', 'expertise'])->whereStatus(1)->where('is_filled', 1)->whereSubscriptionStatus(1);
            $doctors = $doctor->paginate(9);
            foreach ($doctors as $doctor) {
                $doctor['is_fav'] = $this->checkFavourite($doctor['id']);
                $doctor->hospital = (new CustomController)->getHospital($doctor['id']);
            }
            $view = view('website.doctors', compact('doctors', 'currency', 'categories', 'subscriptions', 'languages'))->render();
            return response()->json(['html' => $view, 'success' => true]);
        }
        if (isset($data['treatment_id'])) {
            $doctor = $doctor->where('treatment_id', $data['treatment_id']);
        }
        if (isset($data['single_doctor'])) {
            if (isset($data['search_doctor']) && $data['search_doctor'] != null) {
                $doctor->where('name', 'LIKE', '%' . $data['search_doctor'] . "%");
            }
            if (isset($data['doc_lat']) && isset($data['doc_lang']) && $data['doc_lat'] != null) {
                $radius = Setting::first()->radius;
                $hospital = Hospital::whereStatus(1)->GetByDistance($data['doc_lat'], $data['doc_lang'], $radius)->get(['id']);
                $doctor->whereIn('hospital_id', $hospital);
            }
            $doctors = $doctor->values()->paginate(9);
            foreach ($doctors as $doctor) {
                $doctor['is_fav'] = $this->checkFavourite($doctor['id']);
                $doctor['hospital'] = (new CustomController)->getHospital($doctor['id']);
            }
            return view('website.doctors', compact('doctors', 'currency', 'categories', 'subscriptions', 'languages'));
        }

        if ($request->has('language') || $request->has('specialisation') || ($request->has('date') && $request->date != '')) {
            $doctors = $doctor->get();
            $filteredDoctorId = [];
            foreach ($doctors as $singleDoctor) {
                $timeslots = [];
                if ($request->date != '') {
                    $timeslots = (new CustomController)->timeSlot($singleDoctor->id, $request->date);
                }

                if ($request->date == '' || count($timeslots)) {
                    $therapistSpecializations = TherapistSpecializations::where('doctor_user_id', $singleDoctor->user_id)->first();
                    $specialisationId = json_decode($therapistSpecializations->specialisation_id ?? '') ?? [];
                    $languageId = json_decode($singleDoctor->language ?? '') ?? [];

                    if ($request->has('language') && $request->has('specialisation')) {
                        if (array_intersect($request->language, $languageId) && array_intersect($request->specialisation, $specialisationId ?? [])) {
                            if ($request->date != '') {
                                if (count($timeslots)) {
                                    array_push($filteredDoctorId, $singleDoctor->id);
                                }
                            } else {
                                array_push($filteredDoctorId, $singleDoctor->id);
                            }
                        }
                    } else if ($request->has('language')) {
                        if (array_intersect($request->language, $languageId)) {
                            if ($request->date != '') {
                                if (count($timeslots)) {
                                    array_push($filteredDoctorId, $singleDoctor->id);
                                }
                            } else {
                                array_push($filteredDoctorId, $singleDoctor->id);
                            }
                        }
                    } else if ($request->has('specialisation')) {
                        if (array_intersect($request->specialisation, $specialisationId)) {
                            if ($request->date != '') {
                                if (count($timeslots)) {
                                    array_push($filteredDoctorId, $singleDoctor->id);
                                }
                            } else {
                                array_push($filteredDoctorId, $singleDoctor->id);
                            }
                        }
                    } else if ($request->date != '') {
                        if (count($timeslots)) {
                            array_push($filteredDoctorId, $singleDoctor->id);
                        }
                    }
                }
            }
            $doctor = $doctor->whereIn('id', $filteredDoctorId);
        }

        $doctors = $doctor->paginate(9);
        foreach ($doctors as &$dd) {
            $dd['is_fav'] = $this->checkFavourite($dd['id']);
            $dd->hospital = (new CustomController)->getHospital($dd['id']);

            $dd['todaytimeSlot'] = $dd->todaytimeSlot();
        }



        foreach ($doctors as $doctor) {

            $expertiseArea = TherapistSpecializations::where('doctor_user_id', $doctor->user_id)->first();
            $doctor->expertiseArea = Category::whereIn('id', json_decode($expertiseArea->specialisation_id ?? '') ?? [])->get()->pluck('name')->toArray();
            $doctor->language = Language::whereIn('id', json_decode($doctor->language ?? '') ?? [])->get()->pluck('name')->toArray();
        }

        return view('website.doctors', compact('doctors', 'currency', 'categories', 'subscriptions', 'languages', 'request'));
    }

    public function doctor_profile(Request $request, $id, $name)
    {
        $setting = Setting::first();
        $doctor = Doctor::with(['category', 'expertise'])->find($id);
        $doctor->hospital = (new CustomController)->getHospital($id);
        $doctor->workHour = WorkingHour::where('doctor_id', $id)->get();
        $expertiseArea = TherapistSpecializations::where('doctor_user_id', $doctor->user_id)->first();
        $doctor->expertiseArea = Category::whereIn('id', json_decode($expertiseArea->specialisation_id ?? '') ?? [])->get()->pluck('name')->toArray();
        $doctor->language = Language::whereIn('id', json_decode($doctor->language ?? '') ?? [])->get()->pluck('name')->toArray();

        $specialization = TherapistExpertise::where('doctor_user_id', $doctor->user_id)->first();
        $doctor->specialization = Treatments::whereIn('id', json_decode($specialization->expertise_id ?? '') ?? [])->get()->pluck('name')->toArray();

        $currency = Setting::first()->currency_symbol;
        $reviews = Review::where('doctor_id', $id)->where('status', 'approved')->with('user')->get();
        $doctor->experience = 0;
        if (json_decode($doctor->experience_details)) {
            foreach (json_decode($doctor->experience_details) as $experience) {
                $doctor->experience = $doctor->experience + $experience->experience_years;
            }
        }

        $today_timeslots = (new CustomController)->timeSlot($id, Carbon::today(env('timezone'))->format('Y-m-d'));

        $tomorrow_timeslots = (new CustomController)->timeSlot($id, Carbon::tomorrow()->format('Y-m-d'));

        if (isset($request->package_id)) {
            $subscriptions = Subscription::find($request->package_id);

            Session::put('package_id', $subscriptions->id);
        } else {
            $subscriptions = '';
        }

        if (auth()->user()) {

            $pendingsession = $this->pendingsession(auth()->user()->id);
        } else {

            $pendingsession = 0;
        }

        return view('website.single_doctor', compact('doctor', 'currency', 'reviews', 'today_timeslots', 'tomorrow_timeslots', 'subscriptions', 'request', 'pendingsession'));
    }

    public function addReview(Request $request)
    {
        (new CustomController)->cancel_max_order();
        $request->validate([
            'review' => 'bail|required',
            'rate' => 'bail|required'
        ]);
        $data = $request->all();
        if (Review::where([['session_id', $data['session_id'], ['user_id', auth()->user()->id]]])->exists() != true) {
            $data['doctor_id'] = AppointmentSessions::find($data['session_id'])->doctor_id;
            $data['user_id'] = auth()->user()->id;
            $data['status'] = 'pending';
            Review::create($data);
            return response(['success' => true]);
        } else {
            return response(['success' => false, 'data' => __('Review Already Added.!!')]);
        }
    }

    public function user_profile()
    {

        if (auth()->user()->hasRole('Therapist')) {
            return redirect('/doctor_home');
        } elseif (auth()->user()->hasRole('super admin')) {
            return redirect('/profile');
        }

        $languages = Language::whereStatus(1)->get();
        $fav_docs = Faviroute::where('user_id', auth()->user()->id)->get(['doctor_id']);
        $doctors = Doctor::whereIn('id', $fav_docs)->get();

        $doctorslist = Doctor::whereStatus(1)->get();


        foreach ($doctors as $doctor) {
            $doctor['is_fav'] = $this->checkFavourite($doctor->id);
        }
        $currency = Setting::first()->currency_symbol;
        $useraddress = UserAddress::where('user_id', auth()->user()->id)->get();
        $user = auth()->user();
        (new CustomController)->cancel_max_order();
        $appointments = Appointment::with(['doctor', 'hospital'])->where('user_id', $user->id)->where('payment_status', 1)->orderBy('id', 'DESC')->get();
        $packlist = [];
        $appointmentIds = [];
        foreach ($appointments as $appointment) {
            array_push($appointmentIds, $appointment->appointment_id);
            $appointment->isReview = Review::where('appointment_id', $appointment->id)->exists();

            array_push($packlist, $appointment->package_id);
        }

        $cancel_reason = Setting::first()->cancel_reason;
        $prescriptions = Prescription::with(['doctor', 'appointment'])->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();



        $subscriptions = Subscription::orderBy('id', 'DESC')->whereIn('id', $packlist)->get()->makeHidden(['created_at', 'updated_at']);

        $purchaseMedicines = PurchaseMedicine::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        $test_reports = Report::with('lab:id,name')->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();

        // $conversations = DB::table('conversations')->latest()->get();

        $user_id = auth()->user()->id;

        if (auth()->user()->hasRole('Therapist')) {


            $conversations = DB::table('conversations')->Where('user_id', '=', $user_id)->latest()->get();
        } else {

            $conversations = DB::table('conversations')->Where('user_id', '=', $user_id)->latest()->get();
        }


        $sessions = AppointmentSessions::with(['doctor', 'appointment'])->whereIn('appointment_id', $appointmentIds)->orderBy('appointment_sessions.id', 'DESC')->get();

        foreach ($sessions as $session) {

            if ($session->zoomSessions) {

                $zoomobj = json_decode($session->zoomSessions, true);
                $zoomurl = $zoomobj['meta']['join_url'];
            } else {
                $zoomurl = null;
            }

            $session->zoomurl = $zoomurl;
            $session->isReview = Review::where('session_id', $session->id)->exists();
        }

        $pendingsession = $this->pendingsession($user_id);
        return view('website.user_profile', compact('languages', 'useraddress', 'test_reports', 'prescriptions', 'purchaseMedicines', 'doctors', 'currency', 'appointments', 'cancel_reason', 'conversations', 'subscriptions', 'doctorslist', 'sessions', 'pendingsession'));
    }

    public function update_user_profile(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'name' => 'bail|required',
            'dob' => 'bail|required',
            'gender' => 'bail|required',
        ]);
        $user = auth()->user();
        if ($request->hasFile('image')) {
            (new CustomController)->deleteFile($user->image);
            $data['image'] = (new CustomController)->imageUpload($request->image);
        }
        $user->update($data);
        $this->changelanguage();
        return redirect()->back()->withStatus(__('Client updated successfully..!!'));
    }

    public function addBookmark($doctor_id)
    {
        if (auth()->check()) {
            $user_id = auth()->user()->id;
            $faviroute = Faviroute::where([['user_id', $user_id], ['doctor_id', $doctor_id]])->first();
            if (!$faviroute) {
                $data = [];
                $data['user_id'] = $user_id;
                $data['doctor_id'] = $doctor_id;
                Faviroute::create($data);
                return response(['success' => true, 'msg' => __('Added into faviroute..!!')]);
            } else {
                $faviroute->delete();
                return response(['success' => true, 'msg' => __('Remove from faviroute..!!')]);
            }
        } else {
            return response(['success' => false, 'msg' => __('Login Required.')]);
        }
    }

    public function cancelAppointment(Request $request)
    {
        $data = $request->all();
        $appointment = Appointment::find($data['id']);
        $session = AppointmentSessions::find($data['session_id']);
        $data['session_status'] = 'cancel';
        unset($data['id']);
        $session->update($data);


        $client = User::find($appointment->user_id);
        $therapist = Doctor::find($session->doctor_id);
        $doctor = User::find($therapist->user_id);

        $notification_template = NotificationTemplate::where('title', 'session cancellation')->first();
        $notification_template2 = NotificationTemplate::where('title', 'session cancelled for therapist')->first();

        $detail['user_name'] = $client->name;
        $detail['therapist_name'] = $therapist->name;
        $detail['appointment_date'] = $session->date . ' ' . $session->time;
        $data = ["{{user_name}}", "{{therapist_name}}", "{{appointment_date}}"];

        $message = str_replace($data, $detail, $notification_template->mail_content);
        $message2 = str_replace($data, $detail, $notification_template2->mail_content);

        try {
            Mail::to($client->email)->send(new SendMail($message, $notification_template->subject));
            Mail::to($doctor->email)->send(new SendMail($message2, $notification_template2->subject));
        } catch (\Throwable $th) {
            //throw $th;
        }

        return response(['success' => true]);
    }

    public function set_time(Request $request)
    {
        Session::put('date', $request->date);
        Session::put('time', $request->time);
        Session::put('doctor_id', $request->doctor_id);
        $doctor = Doctor::find($request->doctor_id);
        return redirect('booking/' . $doctor->id . '/' . Str::slug($doctor->name));
    }

    public function checkFavourite($doctor_id)
    {
        if (auth()->user() != null) {
            if (Faviroute::where([['user_id', auth()->user()->id], ['doctor_id', $doctor_id]])->first())
                return true;
            return false;
        }
        return false;
    }

    public function addAddress(Request $request)
    {
        if ($request->from == 'add_new') {
            UserAddress::create($request->all());
        } else {
            $user_address = UserAddress::find($request->id);
            $user_address->update($request->all());
        }
        return redirect()->back();
    }

    public function edit_user_address($address_id)
    {
        $address_id = UserAddress::find($address_id);
        return response(['success' => true, 'data' => $address_id]);
    }

    public function delete_user_address($address_id)
    {
        $user_address = UserAddress::find($address_id);
        $user_address->delete();
        return response(['success' => true]);
    }

    public function booking($id, $name, Request $request)
    {
        /// booking confirm page need to add 

        // print_r($request->all());die();

        if (auth()->user()->hasRole('super admin')) {
            return redirect('home')->withStatus(__('You Can not Book as SuperAdmin..!!'));
        }

        if (auth()->user()) {

            $pendingsession = $this->pendingsession(auth()->user()->id);
        } else {

            $pendingsession = 0;
        }



        $doctor = Doctor::with(['category', 'expertise'])->find($id);
        $doctor->hospital = (new CustomController)->getHospital($doctor->id);
        $date = Session::has('date') ? Session::get('date') : Carbon::now(env('timezone'))->format('Y-m-d');
        $timeslots = (new CustomController)->timeSlot($doctor->id, $date);
        $setting = Setting::find(1);
        $patient_addressess = UserAddress::where('user_id', auth()->user()->id)->get();

        $subscriptions = Subscription::orderBy('id', 'ASC')->get()->makeHidden(['created_at', 'updated_at']);

        if ($pendingsession > 0) {


            if (isset($request->session_id) && $request->session_id) {


                $sessiontoday = AppointmentSessions::leftjoin('appointment', 'appointment.appointment_id', 'appointment_sessions.appointment_id')->where('user_id', auth()->user()->id)->where('appointment_sessions.id', $request->session_id)->select('appointment_sessions.*', 'appointment.id as appid')->first();
            } else {

                $sessiontoday = AppointmentSessions::leftjoin('appointment', 'appointment.appointment_id', 'appointment_sessions.appointment_id')->where('user_id', auth()->user()->id)->where('payment_status', 1)->where('session_status', 'pending')->where('appointment_sessions.doctor_id', null)->select('appointment_sessions.*', 'appointment.id as appid')->first();
            }




            // Log::info($sessiontoday);
            // Log::info('testno1');


            if (isset($sessiontoday->id)) {

                $sessiontoday->doctor_id = $doctor->id;
                $sessiontoday->session_date = $request->date;
                $sessiontoday->session_timeslot = $request->time;
                $sessiontoday->save();


                Log::info($sessiontoday);


                $request->merge([
                    'topic' => 'Myminddoctor Appointment',
                    'start_time' => $request->date . ' ' . $request->time,
                    'duration' => 30,
                    'agenda' => 'Appointment with Therapist',
                    'host_video' => 1,
                    'appointment_id' => $sessiontoday->appid,
                    'participant_video' => 1,
                    'therapist_email' => $doctor->email,
                    'therapist_name' =>  $doctor->name,
                    'members' => [$doctor->id, auth()->user()->id],
                    'time_zone' => 'Asia/Singapore',
                    'sessionId' => $sessiontoday->id
                ]);


                $zoomdata = $this->meetingRepository->store($request->all());


                $images = null;

                Log::info($zoomdata);


                if (isset($doctor->user_id)) {


                    // Log::info('test');


                    DB::table('conversations')->insert([
                        'user_id' => auth()->user()->id,
                        'to_user_id' => $doctor->user_id,
                        'message' => 'Hi I like to connect with MMD',
                        'checked' => 0,
                        'image' => json_encode($images),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    // print_r($doctor->user_id);die();
                }

                try {
                    $this->sendmailconfirmation($appointmentdetails);
                    $this->therapistmailconfirmation($appointmentdetails, $doctor);
                } catch (\Throwable $th) {
                }
            }


            return view('website.booking', compact('doctor', 'timeslots', 'setting', 'date', 'patient_addressess', 'subscriptions', 'pendingsession', 'sessiontoday', 'request'));
        } else {

            return view('website.booking', compact('doctor', 'timeslots', 'setting', 'date', 'patient_addressess', 'subscriptions', 'pendingsession', 'request'));
        }
    }


    public function startchat(Request $request){

        $images=[];
        DB::table('conversations')->insert([
            'user_id' => $request->user_id,
            'to_user_id' => $request->to_user_id,
            'message' => 'Hi I like to connect with MMD',
            'checked' => 0,
            'image' => json_encode($images),
            'created_at' => now(),
            'updated_at' => now()
        ]);


        if (auth()->user()->hasRole('Therapist')) {
            return redirect('/conversation');
        } else{
            return redirect('/user_profile');
        }


    }

    public function packagebooking($id, $name)
    {
        $package = Subscription::find($id);

        $date = Session::has('date') ? Session::get('date') : Carbon::now(env('timezone'))->format('Y-m-d');

        $setting = Setting::find(1);



        $subscriptions = Subscription::orderBy('id', 'DESC')->get()->makeHidden(['created_at', 'updated_at']);

        return view('website.packagebooking', compact('package', 'setting', 'date', 'subscriptions'));
    }

    public function all_pharmacy(Request $request)
    {
        $pharmacies = Pharmacy::whereStatus(1);

        if ($request->has('category')) {
            $data = $request->all();
            if (in_array('latest', $data['category'])) {
                $pharmacies = $pharmacies->orderBy('id', 'DESC');
            }
            if (in_array('opening', $data['category'])) {
                $Ids = array();
                $current_time = Carbon::now(env('timezone'));
                $current_day = Carbon::now(env('timezone'))->format('l');
                $tempPharmacy = Pharmacy::whereStatus(1)->get();
                foreach ($tempPharmacy as $value) {
                    $pharmacyHours = PharmacyWorkingHour::where([['pharmacy_id', $value->id], ['day_index', $current_day], ['status', 1]])->first();
                    if ($pharmacyHours) {
                        $hours = json_decode($pharmacyHours->period_list);
                        foreach ($hours as $hour) {
                            $temp = $current_time->between($hour->start_time, $hour->end_time);
                            if ($temp)
                                array_push($Ids, $value->id);
                        }
                    }
                }
                $pharmacies = $pharmacies->whereIn('id', $Ids);
            }
            $pharmacies = $pharmacies->get();
            foreach ($pharmacies as $pharmacy) {
                $dayname = Carbon::now(env('timezone'))->format('l');
                $workingHours = PharmacyWorkingHour::where([['pharmacy_id', $pharmacy->id], ['day_index', $dayname]])->first()->period_list;
                $pharmacy->openTime = json_decode($workingHours)[0]->start_time;
            }
            $view = view('website.display_pharmacy', compact('pharmacies'))->render();
            return response()->json(['html' => $view, 'success' => true]);
        }
        if ($request->has('lat') && $request->has('lang')) {
            $data = $request->all();
            $radius = Setting::first()->radius;
            $pharmacies = $pharmacies->GetByDistance($data['lat'], $data['lang'], $radius)->get();
            foreach ($pharmacies as $pharmacy) {
                $dayname = Carbon::now(env('timezone'))->format('l');
                $workingHours = PharmacyWorkingHour::where([['pharmacy_id', $pharmacy->id], ['day_index', $dayname]])->first()->period_list;
                $pharmacy->openTime = json_decode($workingHours)[0]->start_time;
            }
            $view = view('website.display_pharmacy', compact('pharmacies'))->render();
            return response()->json(['html' => $view, 'success' => true]);
        }
        if ($request->has('search_val')) {
            $pharmacies = $pharmacies->where('name', 'LIKE', '%' . $request->search_val . "%")->get();
            foreach ($pharmacies as $pharmacy) {
                $dayname = Carbon::now(env('timezone'))->format('l');
                $workingHours = PharmacyWorkingHour::where([['pharmacy_id', $pharmacy->id], ['day_index', $dayname]])->first()->period_list;
                $pharmacy->openTime = json_decode($workingHours)[0]->start_time;
            }
            $view = view('website.display_pharmacy', compact('pharmacies'))->render();
            return response()->json(['html' => $view, 'success' => true]);
        }
        if ($request->has('single_pharmacy')) {
            $data = $request->all();
            if ($data['pharmacy_lat'] != null && $data['pharmacy_lang'] != null) {
                $radius = Setting::first()->radius;
                $pharmacies = $pharmacies->GetByDistance($data['pharmacy_lat'], $data['pharmacy_lang'], $radius);
            }
            if ($request->has('search_pharmacy')) {
                $pharmacies = $pharmacies->where('name', 'LIKE', '%' . $request->search_val . "%");
            }
            $pharmacies = $pharmacies->get();
            foreach ($pharmacies as $pharmacy) {
                $dayname = Carbon::now(env('timezone'))->format('l');
                $workingHours = PharmacyWorkingHour::where([['pharmacy_id', $pharmacy->id], ['day_index', $dayname]])->first()->period_list;
                $pharmacy->openTime = json_decode($workingHours)[0]->start_time;
            }
            return view('website.all_pharmacy', compact('pharmacies'));
        } else {
            $pharmacies = $pharmacies->get();
        }
        foreach ($pharmacies as $pharmacy) {
            $dayname = Carbon::now(env('timezone'))->format('l');
            $workingHours = PharmacyWorkingHour::where([['pharmacy_id', $pharmacy->id], ['day_index', $dayname]])->first()->period_list;
            $pharmacy->openTime = json_decode($workingHours)[0]->start_time;
        }
        return view('website.all_pharmacy', compact('pharmacies'));
    }

    // BookAppointment
    public function bookAppointment(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'appointment_for' => 'bail|required',
            'illness_information' => 'bail|required',
            'patient_name' => 'bail|required',
            'age' => 'bail|required|numeric',
            'patient_address' => 'bail|required',
            'phone_no' => 'bail|required|numeric|digits_between:6,12',
            'drug_effect' => 'bail|required',
            'note' => 'bail|required',
            'date' => 'bail|required',
            'package_id' => 'required',
            'time' => 'bail|required'
        ]);
        $data['appointment_id'] =  '#' . rand(100000, 999999);
        $data['user_id'] = auth()->user()->id;
        $data['appointment_status'] = 'pending';
        if ($request->hasFile('report_image')) {
            $report = [];
            for ($i = 0; $i < count($data['report_image']); $i++) {
                array_push($report, (new CustomController)->imageUpload($request->report_image[$i]));
            }
            $data['report_image'] = json_encode($report);
        }

        $doctor = Doctor::find($data['doctor_id']);
        if ($doctor->based_on == 'commission') {
            // $comm = $data['amount'] * $doctor->commission_amount;
            // $data['admin_commission'] = intval($comm / 100);
            // $data['doctor_commission'] = intval($data['amount'] - $data['admin_commission']);
        } else {
            DoctorSubscription::where('doctor_id', $doctor->id)->latest()->first()->increment('booked_appointment');
        }

        $data['payment_type'] = strtoupper($data['payment_type']);
        $data = array_filter($data, function ($a) {
            return $a !== "";
        });
        unset($data['doctor_id']);
        unset($data['date']);
        unset($data['time']);
        $appointment = Appointment::create($data);

        $subscriptions = Subscription::find($data['package_id']);
        $total_appointments = $subscriptions->total_appointment;

        $sessionId = 0;
        for ($i = 0; $i < $total_appointments; $i++) {
            $appointmentSession = [];
            $appointmentSession['appointment_id'] = $data['appointment_id'];
            $appointmentSession['session_name'] = "session_" . $i;
            if ($i == 0) {
                $appointmentSession['session_status'] = "booked";
                $appointmentSession['session_date'] = $request->date;
                $appointmentSession['session_timeslot'] = $request->time;
            } else {
                $appointmentSession['session_status'] = "pending";
            }
            $session = AppointmentSessions::create($appointmentSession);

            if ($i == 0) {
                $sessionId = $session->id;
            }
        }
        //zoom call 

        $doctoruser = User::find($doctor->user_id);

        $request->merge([
            'topic' => 'Myminddoctor Appointment',
            'start_time' => $request->date . ' ' . $request->time,
            'duration' => 30,
            'agenda' => 'Appointment with Therapist',
            'host_video' => 1,
            'appointment_id' => $appointment->id,
            'participant_video' => 1,
            'therapist_email' => $doctoruser->email,
            'therapist_name' =>  $doctoruser->name,
            'members' => [$request->doctor_id, $data['user_id']],
            'time_zone' => 'Asia/Singapore',
            'sessionId' => $sessionId
        ]);


        $zoomdata = $this->meetingRepository->store($request->all());




        session()->forget('doctor_id');
        session()->forget('time');
        session()->forget('date');


        $payment = $this->instapay($request->all());

        if (isset($payment['longurl'])) {

            $appointment->payment_order_id = $payment['id'];
            $appointment->save();

            $success = true;
        } else {
            $success = false;
        }
        return response(['success' => $success, 'zoomdata' => $zoomdata, 'payment' => $payment]);
    }



    public function sendmailconfirmation($appointment)
    {

        $notification_template = NotificationTemplate::where('title', 'create appointment')->first();
        $msg_content = $notification_template->msg_content;
        $mail_content = $notification_template->mail_content;
        $detail['user_name'] = auth()->user()->name;
        $detail['appointment_id'] = $appointment->appointment_id;
        $detail['date'] = $appointment->date;
        $detail['time'] = $appointment->time;
        $detail['app_name'] = Setting::first()->business_name;
        $user_data = ["{{user_name}}", "{{appointment_id}}", "{{date}}", "{{time}}", "{{app_name}}"];
        $mail1 = str_replace($user_data, $detail, $mail_content);
        $message1 = str_replace($user_data, $detail, $msg_content);
        if (Setting::first()->patient_mail == 1) {
            try {
                Mail::to(auth()->user()->email)->send(new SendMail($mail1, $notification_template->subject));
            } catch (\Throwable $th) {
            }
        }
    }


    public function therapistmailconfirmation($appointment, $doctor)
    {

        $notification_template1 = NotificationTemplate::where('title', 'therapist book appointment')->first();
        $doc_msg_content = $notification_template1->msg_content;
        $doc_mail_content = $notification_template1->mail_content;
        $detail1['doctor_name'] = $doctor->name;
        $detail1['appointment_id'] = $appointment->appointment_id;
        $detail1['date'] = $appointment->date;
        $detail1['user_name'] = auth()->user()->name;
        $detail1['app_name'] = Setting::first()->business_name;
        $doctor_data = ["{{doctor_name}}", "{{appointment_id}}", "{{date}}", "{{user_name}}", "{{app_name}}"];
        $doc_mail = str_replace($doctor_data, $detail1, $doc_mail_content);
        $doc_message = str_replace($doctor_data, $detail1, $doc_msg_content);
        $doctor_user = User::where('id', $doctor->user_id)->first();
        if (Setting::first()->doctor_mail == 1) {
            try {
                Mail::to($doctor_user->email)->send(new SendMail($doc_mail, $notification_template1->subject));
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }

    public function instapay($request)
    {

        $user = auth()->user();
        $ch = curl_init();


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.instamojo.com/oauth2/token/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

        $payload = array(
            'grant_type' => 'client_credentials',
            'client_id' => 'sGUbCaFlRnF4QWQ85BL5C2pa2u5AcOI5murkJEi4',
            'client_secret' => 'NjIJsUCN45sUAbuEU3zqZ5ZMDKTyjMJTZudmfGN0r4VRgII8iobXABvn63NUaO8CUBzf9wEgslbroxMpawTUuJtFf4VCGs94P8AqBQ5FIzvA6jxvop4b7RdEqypp5799'
        );

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);

        $resarray = json_decode($response, true);





        curl_setopt($ch, CURLOPT_URL, 'https://api.instamojo.com/v2/payment_requests/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $resarray['access_token']));

        $payload = array(
            'purpose' => 'MMD Booking -' . $request['appointment_id'],
            'amount' => $request['amount'],
            'buyer_name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'redirect_url' => 'https://myminddoctor.com/paymentverify',
            'send_email' => 'True',
            'webhook' => 'https://myminddoctor.com/paymentverify',
            'allow_repeated_payments' => 'False',
        );

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $linkresponse = curl_exec($ch);
        curl_close($ch);


        return json_decode($linkresponse, true);
    }


    public function paymentverify(Request $request)
    {

        Log::info($request->all());
        if ($request->payment_status == 'Credit') {
            $status = 1;
        } else {
            $status = 1;
        }
        Appointment::where('payment_order_id', '=', $request->payment_request_id)->update(['payment_id' => $request->payment_id, 'payment_type' => 'Instamojo', 'payment_status' => $status, 'appointment_status' => 'approve']);


        $apptdetails = Appointment::where('payment_order_id', '=', $request->payment_request_id)->first();


        $images = null;

        if ($apptdetails->doctor) {
            if (isset($apptdetails->user_id)) {
                DB::table('conversations')->insert([
                    'user_id' => $apptdetails->user_id,
                    'to_user_id' => $apptdetails->doctor->user_id,
                    'message' => 'Hi I like to connect with MMD',
                    'checked' => 0,
                    'image' => json_encode($images),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }


        return redirect('/user_profile')->with('status', __('Success'));
    }
    public function displayTimeslot(Request $request)
    {
        $timeslots = (new CustomController)->timeSlot($request->doctor_id, $request->date);
        return response(['success' => true, 'data' => $timeslots]);
    }

    // Check Coupen
    public function checkCoupen(Request $request)
    {
        $data = $request->all();
        $coupen = Offer::where('offer_code', $request->offer_code)->whereColumn('max_use', '>', 'use_count')->first();
        if ($coupen) {
            $users = explode(',', $coupen->user_id);
            if (($key = array_search(auth()->user()->id, $users)) !== false) {
                $exploded_date = explode(' - ', $coupen->start_end_date);
                $currentDate = date('Y-m-d', strtotime($data['date']));
                if (($currentDate >= $exploded_date[0]) && ($currentDate <= $exploded_date[1])) {
                    $discount = array();
                    $discount['discount_id'] = $coupen->id;
                    if ($coupen->is_flat == 1) {
                        $discount['price'] = $coupen->flatDiscount;
                    } else {
                        if ($coupen->discount_type == 'amount')
                            $discount['price'] = $coupen->discount;
                        if ($coupen->discount_type == 'percentage') {
                            $temp = $data['amount'] * $coupen->discount;
                            $discount['price'] = $temp / 100;
                        }
                    }
                    if (intval($discount['price']) > $coupen->min_discount)
                        $discount['price'] = $coupen->min_discount;
                    $discount['finalAmount'] = $data['amount'] - $discount['price'];
                    return response(['success' => true, 'data' => $discount, 'currency' => Setting::first()->currency_symbol]);
                } else {
                    return response(['success' => false, 'data' => __('Coupen is Expired.')]);
                }
            } else {
                return response(['success' => false, 'data' => __('Coupen is not valid for this user..!!')]);
            }
        } else {
            return response(['success' => false, 'data' => __('Coupen code is invalid...!!')]);
        }
    }

    public function changelanguage()
    {
        App::setLocale(auth()->user()->language);
        session()->put('locale', auth()->user()->language);
        $direction = Language::where('name', auth()->user()->language)->first()->direction;
        session()->put('direction', $direction);
        return true;
    }

    public function user_privacy_policy()
    {
        $privacy_policy = Setting::first()->privacy_policy;
        return view('website.privacy_policy', compact('privacy_policy'));
    }

    public function user_about_us()
    {
        $about_us = Setting::first()->about_us;
        return view('website.about_us', compact('about_us'));
    }

    public function offer()
    {
        $offers = Offer::whereStatus(1)->get();
        $currency = Setting::first()->currency_symbol;
        return view('website.offer', compact('offers', 'currency'));
    }

    public function forgot_password()
    {
        return view('website.forgot_password');
    }

    public function user_forgot_password(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (!$user->hasAnyRole(Role::all())) {
                $notification_template = NotificationTemplate::where('title', 'forgot password')->first();
                $password = rand(100000, 999999);
                $detail['user_name'] = $user->name;
                $detail['password'] = $password;
                $detail['app_name'] = Setting::first()->business_name;
                $data = ["{{user_name}}", "{{password}}", "{{app_name}}"];
                $user->password = Hash::make($password);
                $user->save();
                $message1 = str_replace($data, $detail, $notification_template->mail_content);
                try {
                    Mail::to($user->email)->send(new SendMail($message1, $notification_template->subject));
                } catch (\Throwable $th) {
                    //throw $th;
                }
                return redirect()->back()->with('status', __('Password sent into your mail'));
            } else
                return redirect()->back()->withErrors(__('Invalid Email Address'));
        } else
            return redirect()->back()->withErrors(__('User not found'));
    }

    public function single_pharmacy($id, $name)
    {
        $pharmacy = Pharmacy::find($id);
        $dayname = Carbon::now(env('timezone'))->format('l');
        $workingHours = PharmacyWorkingHour::where([['pharmacy_id', $pharmacy->id], ['day_index', $dayname]])->first()->period_list;
        $pharmacy->openTime = json_decode($workingHours)[0]->start_time;
        $pharmacy->workHour = PharmacyWorkingHour::where('pharmacy_id', $id)->get();
        return view('website.single_pharmacy', compact('pharmacy'));
    }

    public function medicine($id, $name)
    {
        $medicine = Medicine::find($id);
        $currency = Setting::first()->currency_symbol;
        return view('website.single_medicine', compact('medicine', 'currency'));
    }

    public function pharmacy_product(Request $request)
    {
        $pharmacy = Pharmacy::all();
        $categories = MedicineCategory::whereStatus(1)->orderBy('id', 'DESC')->get();
        $currency = Setting::first()->currency_symbol;

        $medicines = Medicine::get();

        return view('website.pharmacy_product', compact('pharmacy', 'medicines', 'currency', 'categories'));
    }

    public function assesment(Request $request, $id)
    {
        $blog = Pharmacy::find($id);
        return view('website.single_assesment', compact('blog'));
    }

    public function assesmentsingle(Request $request, $id)
    {
        $blog = Pharmacy::find($id);
        $questions = json_decode($blog->delivery_charges);
        return view('website.singleask', compact('blog', 'questions'));
    }

    public function finalsubmit(Request $request)
    {
        $data = $request->all();
        $sets = [];
        $totalscore = 0;

        for ($i = 0; $i < count($data['questions']); $i++) {
            $temp['question'] = $data['questions'][$i];
            if (isset($data['answers'][$i])) {
                $tempasw = $data['answers'][$i];
                $newlists = explode('++', $tempasw);
                $temp['answer'] = $newlists[0];
                $temp['score'] = $newlists[1];
            } else {
                $temp['answer'] = '';
                $temp['score'] = 0;
            }


            $totalscore = $totalscore + $temp['score'];
            array_push($sets, $temp);
        }

        $category = Pharmacy::find($request->category);
        ReportData::create(['category_id' => $request->category, 'data' => json_encode($sets), 'user_id' => auth()->user()->id]);


        $doctors = Doctor::whereStatus(1)->get()->take(5);

        foreach ($doctors as $doctor) {

            $expertiseArea = TherapistSpecializations::where('doctor_user_id', $doctor->user_id)->first();
            $doctor->expertiseArea = Category::whereIn('id', json_decode($expertiseArea->specialisation_id ?? '') ?? [])->get()->pluck('name')->toArray();
            $doctor->language = Language::whereIn('id', json_decode($doctor->language ?? '') ?? [])->get()->pluck('name')->toArray();
        }


        return view('website.reportfinal', compact('request', 'sets', 'category', 'totalscore', 'doctors'));
    }





    public function addCart(Request $request)
    {
        $data = $request->all();
        $medicine = Medicine::find($data['id']);
        $cartString = '';
        if (Session::get('cart') == null) {
            if ($medicine->total_stock > $medicine->use_stock) {
                if ($data['operation'] == "plus") {
                    $master = array();
                    $master['id'] = $request->id;
                    $master['price'] = intval($medicine->price_pr_strip);
                    $master['original_price'] = intval($medicine->price_pr_strip);
                    $master['qty'] = 1;
                    $master['image'] = $medicine->full_image;
                    $master['name'] = $medicine->name;
                    $master['prescription_required'] = $medicine->prescription_required;
                    $master['available_stock'] = $medicine->total_stock - $medicine->use_stock;
                    $master['use_stock'] = intval($medicine->use_stock) + 1;
                    Session::push('cart', $master);
                    Session::put('pharmacy', Pharmacy::find($data['pharmacy_id']));
                    $price = intval($medicine->price_pr_strip);
                    $qty = 1;
                    $cartString .= '<div class="counter">';
                    $cartString .= '<div class="d-flex align-items-center ">';
                    $cartString .= '<span class="minus btn" onclick="addCart(' . $medicine->id . ',' . "`minus`" . ')"  id="minus' . $medicine->id . '" href="javascrip:void(0)">-</span>';
                    $cartString .= '<p class="value text-center m-auto" id="txtCart' . $medicine->id . '" name="quantity' . $medicine->id . '">1</p>';
                    $cartString .= '<span class="incris btn" onclick="addCart(' . $medicine->id . ',' . "`plus`" . ')"  id="plus' . $medicine->id . '" href="javascrip:void(0)">+</span>';
                    $cartString .= '</div></div>';
                    $total_items = count(Session::get('cart'));
                    $total_price = array_sum(array_column(Session::get('cart'), 'price'));
                    return response(['success' => true, 'data' => ['cartString' => $cartString, 'item_price' =>  $medicine->price_pr_strip, 'total_items' => $total_items, 'total_price' => $total_price]]);
                }
            } else {
                return response(['success' => false, 'data' => 'Out of stock']);
            }
        } else {
            if (Session::get('pharmacy')->id == $data['pharmacy_id']) {
                $session = Session::get('cart');
                if (in_array($request->id, array_column(Session::get('cart'), 'id'))) {
                    foreach ($session as $key => $value) {
                        if ($session[$key]['qty'] < $value['available_stock']) {
                            if ($value['id'] == $data['id']) {
                                if ($data['operation'] == "plus") {
                                    if ($medicine->total_stock > $medicine->use_stock) {
                                        $session[$key]['qty'] += 1;
                                        $session[$key]['price'] = $session[$key]['price'] + $medicine->price_pr_strip;
                                        $session[$key]['use_stock'] = $session[$key]['use_stock'] + 1;
                                        $price = $session[$key]['price'];
                                        $qty = $session[$key]['qty'];
                                    } else {
                                        return response(['success' => false, 'data' => 'out of stock']);
                                    }
                                } else {
                                    if ($session[$key]['qty'] > 0) {
                                        $session[$key]['qty'] -= 1;
                                        $session[$key]['price'] = $session[$key]['price'] - $medicine->price_pr_strip;
                                        $session[$key]['use_stock'] = $session[$key]['use_stock'] - 1;
                                        $price = $session[$key]['price'];
                                        $qty = $session[$key]['qty'];
                                    }
                                    if (intval($session[$key]['qty']) == 0) {
                                        $cartString .= '<a href="javascript:void(0);" onclick="addCart(' . $session[$key]['id'] . ',`plus`)" class="' . $session[$key]['id'] . 'cart-icon">';
                                        $cartString .= '<i class="bx bxs-cart-add btn"></i></a>';
                                        unset($session[$key]);
                                    }
                                }
                            }
                        } else {
                            return response(['success' => false, 'data' => 'Out of stock']);
                        }
                    }
                    Session::put('cart', array_values($session));
                    $total_items = count(Session::get('cart'));
                    $total_price = array_sum(array_column(Session::get('cart'), 'price'));
                    return response(['success' => true, 'data' => ['qty' => $qty, 'item_price' =>  $price, 'total_items' => $total_items, 'total_price' => $total_price, 'cartString' => $cartString]]);
                } else {
                    if ($medicine->total_stock > $medicine->use_stock) {
                        if ($data['operation'] == "plus") {
                            $master = array();
                            $master['id'] = $request->id;
                            $master['price'] = intval($medicine->price_pr_strip);
                            $master['original_price'] = intval($medicine->price_pr_strip);
                            $master['qty'] = 1;
                            $master['image'] = $medicine->full_image;
                            $master['name'] = $medicine->name;
                            $master['prescription_required'] = $medicine->prescription_required;
                            $master['available_stock'] = $medicine->total_stock - $medicine->use_stock;
                            $master['use_stock'] = intval($medicine->use_stock) + 1;
                            array_push($session, $master);
                            $price = intval($medicine->price_pr_strip);
                            $qty = 1;
                            $cartString .= '<div class="counter">';
                            $cartString .= '<div class="d-flex align-items-center ">';
                            $cartString .= '<span class="minus btn" onclick="addCart(' . $medicine->id . ',' . "`minus`" . ')"  id="minus' . $medicine->id . '" href="javascrip:void(0)">-</span>';
                            $cartString .= '<p class="value text-center m-auto" id="txtCart' . $medicine->id . '" name="quantity' . $medicine->id . '">1</p>';
                            $cartString .= '<span class="incris btn" onclick="addCart(' . $medicine->id . ',' . "`plus`" . ')"  id="plus' . $medicine->id . '" href="javascrip:void(0)">+</span>';
                            $cartString .= '</div></div>';
                        }
                        Session::put('cart', array_values($session));
                        $total_items = count(Session::get('cart'));
                        $total_price = array_sum(array_column(Session::get('cart'), 'price'));
                        return response(['success' => true, 'data' => ['qty' => $qty, 'item_price' =>  $medicine->price_pr_strip, 'total_price' => $total_price, 'total_items' => $total_items, 'cartString' => $cartString]]);
                    } else {
                        return response(['success' => false, 'data' => 'Out of stock']);
                    }
                }
            } else {
                return response(['success' => false, 'data' => 'pharmacy not same']);
            }
        }
    }

    public function cart()
    {
        if (Session::has('cart')) {
            $currency = Setting::first()->currency_symbol;
            return view('website.cart', compact('currency'));
        } else
            return redirect('/');
    }

    public function remove_single_item($cart_id)
    {
        $session = Session::get('cart');
        foreach ($session as $key => $value) {
            if (isset($cart_id)) {
                if ($value['id'] == $cart_id)
                    unset($session[$key]);
            }
        }
        session(['cart' => $session]);
        if (count(Session::get('cart')) <= 0) {
            session()->forget('cart');
            session()->forget('pharmacy');
        }
        return redirect()->back();
    }

    public function checkout()
    {
        $session = Session::get('cart');
        $grandTotal = 0;
        $prescription = 0;
        foreach ($session as $value) {
            $prescription = $value['prescription_required'] == 1 ? 1 : 0;
        }
        $master = [];
        $master['totalItems'] = count(Session::get('cart'));
        $master['setting'] = Setting::find(1);
        $master['prescription'] = $prescription;
        $master['address'] = UserAddress::where('user_id', auth()->user()->id)->get();
        return view('website.checkout', compact('master'));
    }

    public function getDeliveryCharge(Request $request)
    {
        $data = $request->all();
        $address = UserAddress::find($data['address_id']);
        $distance = $this->getDistance($address);
        $delivery_charge = 0;
        if ($distance != 0) {
            $charges = Session::get('pharmacy')['delivery_charges'];
            foreach (json_decode($charges) as $charge) {
                if ($distance >= intval($charge->min_value) && $distance < intval($charge->max_value)) {
                    $delivery_charge = $charge->charges;
                }
            }
            if ($delivery_charge == 0) {
                $delivery_charge = max(array_column(json_decode($charges), 'charges'));
            }
        }
        return response(['success' => true, 'data' => ['delivery_charge' => intval($delivery_charge), 'currency' => Setting::first()->currency_symbol]]);
    }

    public function bookMedicine(Request $request)
    {
        $data = $request->all();
        if (isset($data['pdf'])) {
            $test = explode('.', $data['pdf']);
            $ext = end($test);
            $name = uniqid() . '.' . 'pdf';
            $location = public_path() . '/prescription/upload';
            $data['pdf']->move($location, $name);
            $data['pdf'] = $name;
        }
        $data['user_id'] = auth()->user()->id;
        $data['medicine_id'] = '#' . rand(100000, 999999);
        $data['payment_type'] = strtoupper($request->payment_type);
        $data['pharmacy_id'] = Session::get('pharmacy')->id;

        $commission = Session::get('pharmacy')->commission_amount;
        $com = $data['amount'] * $commission;
        $data['admin_commission'] = $com / 100;
        $data['pharmacy_commission'] = $data['amount'] - $data['admin_commission'];
        $purchase = PurchaseMedicine::create($data);
        foreach (Session::get('cart') as $value) {
            $master = array();
            $master['purchase_medicine_id'] = $purchase->id;
            $master['medicine_id'] = $value['id'];
            $master['price'] = $value['price'];
            $master['qty'] = $value['qty'];
            $medicine = Medicine::find($value['id']);
            $available_stock = $medicine->total_stock - $value['qty'];
            $medicine->update(['use_stock' => $value['use_stock']]);
            $medicine->update(['total_stock' => $available_stock]);
            MedicineChild::create($master);
        }

        $settle = array();
        $settle['purchase_medicine_id'] = $purchase->id;
        $settle['pharmacy_id'] = $purchase->pharmacy_id;
        $settle['pharmacy_amount'] = $purchase->pharmacy_commission;
        $settle['admin_amount'] = $purchase->admin_commission;
        $settle['payment'] = $purchase->payment_type == 'COD' ? 0 : 1;
        $settle['pharmacy_status'] = 0;
        PharmacySettle::create($settle);
        session()->forget('cart');
        session()->forget('pharmacy');
        return response(['success' => true]);
    }

    public function downloadPDF($id)
    {
        $id = Prescription::find($id);
        $pathToFile = public_path() . "/prescription/upload/" . $id->pdf;
        $name = $id->pdf;
        $headers = array('Content-Type: application/pdf',);
        return response()->download($pathToFile, $name, $headers);
    }

    public function labs(Request $request)
    {
        $labs = Lab::with('user')->whereStatus(1)->orderBy('id', 'DESC');
        $dayname = Carbon::now(env('timezone'))->format('l');
        if (isset($request->lat) && isset($request->lang)) {
            $radius = Setting::first()->radius;
            $labs = $labs->GetByDistance($request->lat, $request->lang, $radius)->get();
            foreach ($labs as $lab) {
                $workingHours = LabWorkHours::where([['lab_id', $lab->id], ['day_index', $dayname]])->first()->period_list;
                $lab->openTime = json_decode($workingHours)[0]->start_time;
            }
            $view = view('website.lab.display_lab', compact('labs'))->render();
            return response()->json(['html' => $view, 'success' => true]);
        }
        if (isset($request->search_val)) {
            $labs = $labs->where('name', 'LIKE', '%' . $request->search_val . "%")->get();
            foreach ($labs as $lab) {
                $workingHours = LabWorkHours::where([['lab_id', $lab->id], ['day_index', $dayname]])->first()->period_list;
                $lab->openTime = json_decode($workingHours)[0]->start_time;
            }
            $view = view('website.lab.display_lab', compact('labs'))->render();
            return response()->json(['html' => $view, 'success' => true]);
        }
        $labs = $labs->get();
        foreach ($labs as $lab) {
            $workingHours = LabWorkHours::where([['lab_id', $lab->id], ['day_index', $dayname]])->first()->period_list;
            $lab->openTime = json_decode($workingHours)[0]->start_time;
        }
        return view('website.lab.lab', compact('labs'));
    }

    public function lab_tests($id, $name)
    {
        $lab = Lab::find($id);
        $pathology_categories = PathologyCategory::whereStatus(1)->get();
        $radiology_categories = RadiologyCategory::whereStatus(1)->get();
        $doctors = Doctor::whereStatus(1)->get();
        $date = Carbon::now(env('timezone'))->format('Y-m-d');
        $timeslots = (new CustomController)->LabtimeSlot($lab->id, $date);
        $setting = Setting::first();
        return view('website.lab.single_lab', compact('lab', 'pathology_categories', 'timeslots', 'date', 'doctors', 'radiology_categories', 'setting'));
    }

    public function pathology_category_wise($id, $lab_id)
    {
        $pathology = Pathology::where([['pathology_category_id', $id], ['lab_id', $lab_id], ['status', 1]])->get();
        return response(['success' => true, 'data' => $pathology]);
    }

    public function single_pathology_details(Request $request)
    {
        $pathology = Pathology::where([['lab_id', $request->lab_id], ['status', 1]])->whereIn('id', $request->id)->get();
        $currency = Setting::first()->currency_symbol;
        $total = $pathology->sum('charge');
        return response(['success' => true, 'total' => $total, 'data' => $pathology, 'currency' => $currency]);
    }

    public function radiology_category_wise($id, $lab_id)
    {
        $pathology = Radiology::where([['radiology_category_id', $id], ['lab_id', $lab_id], ['status', 1]])->get();
        return response(['success' => true, 'data' => $pathology]);
    }

    public function single_radiology_details(Request $request)
    {
        $radiology = Radiology::where([['lab_id', $request->lab_id], ['status', 1]])->whereIn('id', $request->id)->get();
        $currency = Setting::first()->currency_symbol;
        $total = $radiology->sum('charge');
        return response(['success' => true, 'data' => $radiology, 'total' => $total, 'currency' => $currency]);
    }

    public function lab_timeslot(Request $request)
    {
        $timeslots = (new CustomController)->LabtimeSlot($request->lab_id, $request->date);
        return response(['success' => true, 'data'  => $timeslots]);
    }

    public function single_report($report_id)
    {
        $report = Report::find($report_id);
        $currency = Setting::first()->currency_symbol;
        return response(['success' => true, 'data' => $report, 'currency' => $currency]);
    }

    public function test_report(Request $request)
    {
        $request->validate([
            'patient_name' => 'bail|required',
            'age' => 'bail|required|numeric',
            'phone_no' => 'bail|required|numeric|digits_between:6,12',
            'gender' => 'bail|required',
            'pathology_category_id' => 'required_without:radiology_category_id',
            'radiology_category_id' => 'required_without:pathology_category_id',
            'pathology_id' => "required_with:pathology_category_id",
            'radiology_id' => "required_with:radiology_category_id",
            'date' => 'bail|required',
            'time' => 'bail|required',
            'doctor_id' => 'bail|required_if:prescription_required,1',
            'prescription' => 'bail|required_if:prescription_required,1'
        ]);
        $data = $request->all();
        $lab = Lab::find($request->lab_id);
        $data['report_id'] =  '#' . rand(100000, 999999);
        if (isset($data['prescription'])) {
            $test = explode('.', $data['prescription']);
            $ext = end($test);
            $name = uniqid() . '.' . $data['prescription']->getClientOriginalExtension();;
            $location = public_path() . '/report_prescription/upload';
            $data['prescription']->move($location, $name);
            $data['prescription'] = $name;
        }
        $data['user_id'] = auth()->user()->id;
        if (isset($data['pathology_id'])) {
            $data['pathology_id'] = implode(',', $data['pathology_id']);
        }
        if (isset($data['radiology_id'])) {
            $data['radiology_id'] = implode(',', $data['radiology_id']);
        }
        $data = array_filter($data, function ($a) {
            return $a !== "";
        });
        $report = Report::create($data);
        $settle = array();

        $com = $lab->commission * $request->amount;
        $admin_commission = $com / 100;
        $lab_commission = $request->amount - $admin_commission;

        $settle['lab_id'] = $lab->id;
        $settle['report_id'] = $report->id;
        $settle['admin_amount'] = $admin_commission;
        $settle['lab_amount'] = $lab_commission;
        $settle['payment'] = $report->payment_status == 1 ? 1 : 0;
        $settle['lab_status'] = 0;
        LabSettle::create($settle);
        return response(['success' => true]);
    }

    public function getDistance($address)
    {
        $lat1 = $address->lat;
        $lon1 = $address->lang;
        $lat2 = Session::get('pharmacy')['lat'];
        $lon2 = Session::get('pharmacy')['lang'];
        $unit = 'K';
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            $distance = 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);
            if ($unit == "K") {
                $distance = $miles * 1.609344;
            } else if ($unit == "N") {
                $distance = $miles * 0.8684;
            } else {
                $distance = $miles;
            }
        }
        return intval($distance);
    }

    public function download_report($report_id)
    {
        $id = Report::find($report_id);
        $pathToFile = public_path() . "/report_prescription/report/" . $id->upload_report;
        $name = $id->upload_report;
        return response()->download($pathToFile, $name);
    }

    public function blogs(Request $request)
    {
        $categories = Category::whereStatus(1)->orderBy('order_by')->get();
        $blogs = Blog::where([['status', 1], ['release_now', 1]])->orderBy('id', 'DESC');

        if (request()->has('category_id')) {
            $filteredBlogId = [];
            $blogsToFilter = $blogs->get();
            foreach ($blogsToFilter as $blog) {
                $categoryIds = json_decode($blog->category_id ?? '') ?? [];
                if (in_array(request()->category_id, $categoryIds)) {
                    array_push($filteredBlogId, $blog->id);
                }
            }
            $blogs = $blogs->whereIn('id', $filteredBlogId);
        }
        $blogs = $blogs->paginate(9);
        return view('website.blogs', compact('blogs', 'categories', 'request'));
    }

    public function blog($id)
    {
        $blog = Blog::find($id);
        return view('website.single_blog', compact('blog'));
    }

    public function uploadDocument(Request $request)
    {

        $request->validate([
            'appointment_id' => 'bail|required',
            'attachment' => 'bail|required'
        ]);

        $document['appointment_id'] = $request->appointment_id;

        for ($i = 0; $i < count($request->attachment); $i++) {
            $file = $request->attachment[$i];
            $fileName = $file->getClientOriginalName();
            $path = public_path() . '/images/upload/appointmentDocuments';
            $file->move($path, $fileName);

            $document['document_name'] = $fileName;
            AppointmentDocument::create($document);
        }
        return response(['success' => true]);
    }

    public function terms_and_conditions()
    {
        return view('website.terms_and_conditions');
    }

    public function policy_terms()
    {
        $email = Setting::first()->email;
        return view('website.policy_terms', compact('email'));
    }

    public function privacy_policy()
    {
        $email = Setting::first()->email;
        return view('website.mmd_privacy_policy', compact('email'));
    }

    public function cookies_policy()
    {
        $email = Setting::first()->email;
        return view('website.cookies_policy', compact('email'));
    }

    public function buyPackage(Request $request)
    {
        $subscriptions = Subscription::find($request->package_id);
        $setting = Setting::find(1);
        return view('website.payment_page', compact('subscriptions', 'setting'));
    }

    public function buySubscription(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'appointment_for' => 'bail|required',
            'illness_information' => 'bail|required',
            'patient_name' => 'bail|required',
            'age' => 'bail|required|numeric',
            'patient_address' => 'bail|required',
            'phone_no' => 'bail|required|numeric|digits_between:6,12',
            'drug_effect' => 'bail|required',
            'note' => 'bail|required',
            'package_id' => 'required',
        ]);

        $data['appointment_id'] =  '#' . rand(100000, 999999);
        $data['user_id'] = auth()->user()->id;
        $data['appointment_status'] = 'pending';

        $data['payment_type'] = strtoupper($data['payment_type']);
        $data = array_filter($data, function ($a) {
            return $a !== "";
        });

        $appointment = Appointment::create($data);

        $subscriptions = Subscription::find($data['package_id']);
        $total_appointments = $subscriptions->total_appointment;

        for ($i = 0; $i < $total_appointments; $i++) {
            $appointmentSession['appointment_id'] = $data['appointment_id'];
            $appointmentSession['session_name'] = "session_" . $i;
            $appointmentSession['session_status'] = "pending";
            $session = AppointmentSessions::create($appointmentSession);
        }

        if (auth()->user()->hasRole('super admin')) {
            return redirect('patient')->withStatus(__('Package Booked Successfully..!!'));
        }

        $payment = $this->instapay($data);

        if (isset($payment['longurl'])) {

            $appointment->payment_order_id = $payment['id'];
            $appointment->save();

            $success = true;
        } else {
            $success = false;
        }
        return response(['success' => $success, 'payment' => $payment]);
    }

    public function downloadInvoice($packageId)
    {
        $userId = auth()->user()->id;

        $appointment = Appointment::where([['user_id', $userId], ['id', $packageId]])->first();

        $appointment->invoice_id = date('d') . $userId . rand(100, 999);
        $subscription = Subscription::find($appointment->package_id)->first();
        $appointment->package_name = $subscription->name;
        $setting = Setting::find(1);
        $setting->website = env('APP_URL');
        $pdf = PDF::loadView('pdf.invoice', compact('appointment', 'setting'));
        return $pdf->download('invoice.pdf');
    }

    public function downloadInvoiceuser($appointmentid)
    {
        $appointment = Appointment::where('id', $appointmentid)->first();
        $appointment->invoice_id = date('d') . $appointment->user_id . rand(100, 999);
        $subscription = Subscription::find($appointment->package_id)->first();
        $appointment->package_name = $subscription->name;
        $setting = Setting::find(1);
        $setting->website = env('APP_URL');
        $pdf = PDF::loadView('pdf.invoice', compact('appointment', 'setting'));
        return $pdf->download('invoice.pdf');
    }
}
