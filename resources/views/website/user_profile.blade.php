@extends('layout.mainlayout',['active_page' => 'user_profile'])
@section('title',auth()->user()->name.__(' profile'))
@section('content')
<style type="text/css">
   .card-wrap{
      box-shadow: 0.4rem 0.4rem 1rem #c8d0e7, -0.4rem -0.4rem 1.8rem #fff;
   }
</style>
<div class="site-body">
   <div class="full-content">
      <div>
         <div class="content mx-auto">
            <div class="mt-3">
               <!-- <h4>{{ __('Client Dashboard') }}</h4> -->
               @if ($errors->any())
               @foreach ($errors->all() as $item)
               <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ $item }}
               </div>
               @endforeach
               @endif
               @if (Session::has('error'))
               <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ Session::get('error') }}
               </div>
               @endif
               @if (session('status'))
               @include('superAdmin.auth.status',[
                  'status' => session('status')])
               @endif
            </div>
         </div>
      </div>
      <div class="content mx-auto">
         <div class="row">
            <div class="col-md-3">
               <div class="m-2 profile-side-bar-new profile-side-bar pt-3 pb-2 h-100 bg-white">
                  <div class="edit-profile d-flex flex-column">
                     <img src="{{ url('images/upload/'.auth()->user()->image) }}" class="rounded-circle mx-auto my-3" alt="">
                     <h6 class="mb-3 text-center">{{ auth()->user()->name }}</h6>
                  </div>
                  <ul class="edit-profile-menu pb-2 my-2 px-0 position-relative">
                     <li class="user-profile-link active" onclick="seeData('#user-dashboard')">
                        <a href="javascript:void(0)" class="d-flex align-items-center">
                        <i class='bx bxs-dashboard me-2'></i>{{ __('My Dashboard') }}
                        </a>
                     </li>
                     <li class="user-profile-link" onclick="seeData('#user-setting')">
                        <a href="javascript:void(0)" class="d-flex align-items-center">
                        <i class='bx bxs-cog me-2'></i>{{ __('My Profile') }}
                        </a>
                     </li>
                     <li class="user-profile-link" onclick="seeData('#user-sessions')">
                        <a href="javascript:void(0)" class="d-flex align-items-center">
                        <i class='bx bxs-user me-2'></i>{{ __('My Sessions') }}
                        </a>
                     </li>
                     <li class="user-profile-link" onclick="seeData('#chatdiv')">
                        <a href="javascript:void(0)" class="d-flex align-items-center">
                        <i class='bx bxs-chat me-2'></i>{{ __('Messaging') }}
                        </a>
                     </li>
                     <li class="user-profile-link" onclick="seeData('#feedback')">
                        <a href="javascript:void(0)" class="d-flex align-items-center">
                        <i class='bx bxs-star me-2'></i>{{ __('Feedback') }}
                        </a>
                     </li>
                     <li class="user-profile-link" onclick="seeData('#user-changePass')">
                        <a href="javascript:void(0)" class="d-flex align-items-center">
                        <i class='bx bxs-lock me-2'></i>{{__('Change Password')}}
                        </a>
                     </li>
                     <!-- <li class="user-profile-link" onclick="seeData('#user-delete')">
                        <a href="javascript:void(0)" class="d-flex align-items-center">
                        <i class='bx bxs-lock me-2'></i>Delete Account
                        </a>
                     </li> -->

                     <li class="user-profile-link">
                        <a href="{{url('/faq')}}" class="d-flex align-items-center">
                        <i class='bx bxs-message me-2'></i>FAQ
                        </a>
                     </li>

                     <li class="slide">
                        <a href="javascript:void(0)" class="d-flex align-items-center"></a>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="col-md-9">
               <div class="disp-block h-100" id="user-dashboard">
                  <div class="m-2 profile-side-bar p-3 pt-0 h-100 pb-2 bg-white">

                     <div class="row" style="padding-top: 10px;">

                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                           <div class="card card-statistic-1">
                             
                             <div class="card-wrap">
                               <div class="card-header" style="background-color: #ffce10;">
                                 <h6><b>Total Session</b></h6>
                               </div>
                               <div class="card-body">
                                 <h6>{{count($sessions)}}</h6>
                               </div>
                             </div>
                           </div>
                         </div>

                         <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                           <div class="card card-statistic-1">
                             
                             <div class="card-wrap">
                               <div class="card-header"  style="background-color: #ffce10;">
                                 <h6><b>Pending Sessions</b></h6>
                               </div>
                               <div class="card-body">
                                 <h6>{{$pendingsession}}</h6>
                               </div>
                             </div>
                           </div>
                         </div>

                         <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                           <div class="card card-statistic-1">
                             
                             <div class="card-wrap">
                               <div class="card-header"  style="background-color: #ffce10;">
                                 <h6><b>Total Packages</b></h6>
                               </div>
                               <div class="card-body">
                                 <h6>{{count($appointments)}}</h6>
                               </div>
                             </div>
                           </div>
                         </div>
                     </div>

                     <div class="single-nav">
                        <ul class="d-flex justify-content-center border-bottom">
                           <li class="d-flex text-cente active">
                              <a href="javascript:void(0)" class="h-100 w-100" onclick="seeData('#prescription')">{{ __('My Active Packages') }}</a>
                           </li>

                           <li class="d-flex text-cente">
                              <a href="javascript:void(0)" class="h-100 w-100" onclick="seeData('#therapists')">{{ __('My Therapists') }}</a>
                           </li>
                        </ul>
                     </div>
                     <div>
                        <div class="disp-block" id="prescription">
                           <div class="card card-table mb-0">
                              <div class="card-body row">
                                 @foreach ($appointments as $offer)
                                 <div class="col-lg-4 col-md-4">
                                    <div class="single-pricing-table new-single-pricing-table">
                                       <div class="pricing-header ">
                                             <h6>{{ ucfirst($offer->package->name) }}</h6>
                                       </div>
                                       <p>{{$offer->appointment_id}}</p>

                                       <div class="row" style="text-align: center;display: block;">
                                             <img src="images/{{$offer->package->name}}.png" style="width: 28%;">
                                       </div>
                                       <div class="pricing-btn"> 
                                             <h5><span>Rs.</span>{{$offer->amount}}</h5>
                                       </div>
                                       <div class="pricing-features mt-4">
                                       </div>
                                       <div class="pricing-features pricing-features-description mt-4">
                                             <p style="color: black;">
                                                {!! clean($offer->package->first_description) !!}
                                             </p>
                                                <br>
                                                <p>
                                                {!! clean($offer->package->description) !!}
                                             </p>
                                       </div>

                                       <div class="pricing-btn">

                                          <a href="{{ url('download-invoice/'.Str::slug($offer->id)) }}" class="btn rounded-pill">Download Invoice</a>
                                        </div>

                                    </div>
                                 </div>
                                 @endforeach
                              </div>
                           </div>
                        </div>


                        <div class="disp-none" id="therapists">
                           <div class="card card-table mb-0">
                              <div class="card-body row">

                                 @php 

                                 $newarray =[];

                                 @endphp


                                 @foreach ($sessions as $session)

                                 @if(isset($session->doctor) && !in_array($session->doctor->id,$newarray))
                                 <div class="col-lg-4 col-md-4" style="min-height: 30px;">

                                 
                                    <div class="single-pricing-table new-single-pricing-table"  style="min-height: 30px;">
                                       
                                       <div class="row" style="text-align: center;display: block;">
                                             <img src="{{asset('/images/upload/'.$session->doctor->image)}}" style="width: 28%;">
                                       </div>

                                       <div class="pricing-header ">
                                             <h6>{{ $session->doctor->name }}</h6>
                                       </div>
                                       
                                       
                                       <div class="pricing-features pricing-features-description mt-4">
                                             <p style="color: black;">
                                                
                                             </p>
                                               
                                       </div>
                                       
                                    </div>
                                 </div>

                                 @php 

                                 array_push($newarray, $session->doctor->id);
                                 @endphp
                                 @endif
                                 @endforeach
                              </div>
                           </div>
                        </div>


                        <div class="disp-none" id="Purchased_med">
                           <div class="card card-table mb-0">
                              <div class="card-body">
                                 <div class="table-responsive">
                                    <table class="table table-hover datatable table-center mb-0">
                                       <thead>
                                          <tr>
                                             <th>#</th>
                                             <th>{{ __('Id') }}</th>
                                             <th>{{ __('Amount') }}</th>
                                             <th>{{ __('Attechment') }}</th>
                                             <th>{{ __('payment type') }}</th>
                                             <th>{{ __('payment status') }}</th>
                                             <th>{{ __('View Medicine') }}</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach ($purchaseMedicines as $purchaseMedicine)
                                          <tr>
                                             <td>{{ $loop->iteration }}</td>
                                             <td><a href="javascript:void(0);">{{ $purchaseMedicine->medicine_id }}</a>
                                             </td>
                                             <td>{{ $currency }}{{ $purchaseMedicine->amount }}
                                             </td>
                                             <td>
                                                @if (isset($purchaseMedicine->pdf) || $purchaseMedicine->pdf != null)
                                                <a href="{{ url('prescription/upload/' . $purchaseMedicine->pdf) }}" data-fancybox="gallery2">
                                                {{ $purchaseMedicine->pdf }}
                                                </a>
                                                @else
                                                {{ __('Not available') }}
                                                @endif
                                             </td>
                                             <td>{{ $purchaseMedicine->payment_type }}</td>
                                             <td>
                                                @if ($purchaseMedicine->payment_status == 1)
                                                <span
                                                   class="btn btn-sm btn-success">{{ __('Paid') }}</span>
                                                @else
                                                <span
                                                   class="btn btn-sm btn-danger">{{ __('Remaining') }}</span>
                                                @endif
                                             </td>
                                             <td> 
                                                <a onclick="show_medicines({{ $purchaseMedicine->id }})" class="text-info ml-2" href="javascript:void(0)" role="button" data-from="add_new" data-bs-toggle="modal" data-bs-target="#purchased_medicine">
                                                {{__('Medicines')}}
                                                </a>
                                             </td>
                                          </tr>
                                          @endforeach
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="disp-none h-100" id="user-test-report">
                  <div class="m-2 profile-side-bar p-3  pb-2 bg-white h-100">
                     <div class="row row-cols-1 g-0">
                        <div class="card card-table mb-0">
                           <div class="card-body">
                              <div class="table-responsive">
                                 <table class="table table-hover table-center mb-0 datatable">
                                    <thead>
                                       <tr>
                                          <th>#</th>
                                          <th>{{__('Document Name')}}</th>
                                          <th>{{__('Action')}}</th>
                                          <th>{{ __('View') }}</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       @foreach ($test_reports as $test_report)
                                       <tr>
                                          <td>{{ $loop->iteration }}</td>
                                          <td>{{ $test_report->lab['name'] }}</td>
                                          <td><input type="file" name="reportfile" class="form-control"></td>
                                          <td></td>
                                       </tr>
                                       @endforeach
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="disp-none h-100" id="user-add">
                  <div class="m-2 profile-side-bar p-3 pb-2  bg-white h-100">
                     <div class="d-flex  Appointment-detail">
                        <a class="btn ms-auto address_btn" href="javascript:void(0)" role="button" data-from="add_new" data-bs-toggle="modal" data-bs-target="#exampleModal">{{ __('Add new') }}</a>
                     </div>
                     <div class="card card-table mb-0">
                        <div class="card-body">
                           <div class="table-responsive">
                              <table class="table table-hover text-center mb-0 datatable">
                                 <thead>
                                    <tr>
                                       <th>#</th>
                                       <th>{{__('Address')}}</th>
                                       <th>{{__('Action')}}</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach ($useraddress as $uaddress)
                                    <tr>
                                       <td>{{ $loop->iteration }}</td>
                                       <td>{{ $uaddress->address }}</td>
                                       <td class="">
                                          <a href="javascript:void(0)" class="text-success address_btn" data-from="edit" data-id="{{ $uaddress->id }}" data-from="add_new" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                          <i class="far fa-edit"></i>
                                          </a>
                                          <a href="javascript:void(0)" class="text-danger ml-2" onclick="deleteData({{ $uaddress->id }})">
                                          <i class="far fa-trash-alt"></i>
                                          </a>
                                       </td>
                                    </tr>
                                    @endforeach
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="disp-none h-100" id="user-fav">
                  <div class="m-2 profile-side-bar p-3  pb-2 bg-white h-100">
                     <div class="row row-cols-1 g-0">
                        @foreach ($doctors as $doctor)
                        <div class="col">
                           <div class="doct-card p-3 card  m-3  ms-xl-0 pb-2 mb-0 position-relative">
                              <div class="d-flex flex-sm-row flex-column">
                                 <div class="doct-card-img me-3">
                                    <img src="{{ $doctor['fullImage'] }}" class="rounded-circle" alt="...">
                                 </div>
                                 <div class=" doctor-info d-flex flex-column">
                                    <div class="personalInfo">
                                       <div>
                                          <h6>{{ $doctor['name'] }}</h6>
                                       </div>
                                       <div class="d-flex mt-1  text-center">
                                          <i class='bx bx-map'></i>
                                          <p class="mb-0 ps-1">{{ $doctor['hospital']['name'] }}</p>
                                       </div>
                                       <div class="post d-flex mt-2 align-items-center">
                                          <img src="{{ $doctor['category']['fullImage'] }}" alt="">
                                          <p class="ps-2 mb-0">{{ $doctor['category']['name'] }}</p>
                                          <p class="ms-1 ps-1 mb-0 border-start text-muted">
                                             {{ $doctor['expertise']['name'] }}
                                          </p>
                                       </div>
                                       <div class="d-flex flex-sm-row flex-column mt-2">
                                          <div class="rating d-flex align-items-center">
                                             @for ($i = 1; $i < 6; $i++)
                                             @if ($i <= $doctor['rate'])
                                             <i class='bx bxs-star active'></i>
                                             @else
                                             <i class='bx bxs-star'></i>
                                             @endif
                                             @endfor
                                             <span class="d-inline-block average-rating">({{ $doctor['rate'] }})</span>
                                          </div>
                                          <div class="d-flex ms-sm-3 mt-sm-0 mt-3 align-items-center fbk ">
                                             <i class='bx bx-message-dots'></i>
                                             <p class="ms-2"> <span>{{ $doctor['review'] }}</span> {{ __(' Feedback') }}</p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="d-flex mt-2 align-items-center ">
                                       <i class='bx bx-money'></i>
                                       <p class="ms-2"> {{ $currency }} <span>{{ $doctor['appointment_fees'] }}</span></p>
                                    </div>
                                    <div class="location mt-2 mb-2 d-flex">
                                       <i class='bx bx-map'></i>
                                       <p>{{ $doctor['hospital']['address'] }}</p>
                                    </div>
                                    <div class="d-flex align-items-sm-center my-3 flex-sm-row flex-column justify-contentss-between">
                                       <div class="btn-appointment">
                                          <a href="{{ url('doctor_profile/'.$doctor['id'].'/'.Str::slug($doctor['name'])) }}" class="view-profile btn btn-outline-secondary login-btn marg_right">{{__('View Profile')}}</a>
                                       </div>
                                       <div class="btn-appointment mt-sm-0 mt-3">
                                          <a class="btn btn-link text-center mt-0 marg_left" href="{{ url('booking/'.$doctor['id'].'/'.Str::slug($doctor['name'])) }}" role="button">{{ __('Book Appointment') }}</a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div data-id="{{ $doctor['id'] }}" class="position-absolute d-flex align-items-center justify-content-center shadow add-favourite {{ $doctor['is_fav'] == 'true' ? 'active' : '' }}">
                                 <i class='bx bx-bookmark-heart'></i>
                              </div>
                           </div>
                        </div>
                        @endforeach
                     </div>
                  </div>
               </div>
               <div class="disp-none h-100" id="user-setting">
                  <div class="m-2 profile-side-bar p-3 h-100 pb-2 bg-white">
                     <form action="{{ url('update_user_profile') }}" method="post" class="h-100" enctype="multipart/form-data">
                        @csrf
                        <div class="change-avtar">
                           <div class="avatar-upload position-relative">
                              <div class="avatar-edit position-absolute">
                                 <input type='file' name="image" id="imageUpload" class="d-none" accept=".png, .jpg, .jpeg" />
                                 <label for="imageUpload" class="" data-bs-toggle="tooltip" data-bs-placement="right" title="Select new profile pic"></label>
                              </div>
                              <div class="avatar-preview">
                                 <div id="imagePreview" style="background-image: url({{ 'images/upload/'.auth()->user()->image }});">
                                 </div>
                              </div>
                              <div class="mt-2">
                                 <p class="text-center patient-image">{{ __('Client Image') }}</p>
                              </div>
                           </div>
                        </div>
                        <div class="pb-4">
                           <div class="row g-2">
                              <div class="col-md">
                                 <div>
                                    <label for="name" class="form-label mb-1">{{ __('Name') }}</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ auth()->user()->name }}" required>
                                 </div>
                              </div>
                              <div class="col-md">
                                 <div>
                                    <label for="mail" class="form-label mb-1">{{ __('Email') }}</label>
                                    <input type="email" class="form-control" placeholder="Enter email" value="{{ auth()->user()->email }}" disabled>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="pb-4">
                           <div class="row g-2">
                              <div class="col-md">
                                 <div>
                                    <label for="phone" class="form-label mb-1">{{ __('Phone number') }}</label>
                                    <input type="tel" readonly value="{{ auth()->user()->phone_code }}&nbsp;{{ auth()->user()->phone }}" class="form-control" id="phone">
                                 </div>
                              </div>
                              <div class="col-md">
                                 <label for="gender" name="gender" class="form-label mb-1">Relationship Status</label>
                                 <select class="form-select form-control" name="relationship">
                                 <option {{ auth()->user()->relationship == 'single' ? 'selected' : '' }} value="single">{{ __('Single') }}</option>
                                 <option {{ auth()->user()->relationship == 'married' ? 'selected' : '' }} value="married">{{ __('Married') }}</option>
                                 <option {{ auth()->user()->relationship == 'in_a_relationship' ? 'selected' : '' }} value="in_a_relationship">{{ __('In a Relationship') }}</option>
                                 <option {{ auth()->user()->relationship == 'divorced' ? 'selected' : '' }} value="divorced">{{ __('Divorced') }}</option>
                                 <option {{ auth()->user()->relationship == 'widowed' ? 'selected' : '' }} value="widowed">{{ __('Widowed') }}</option>
                                 <option {{ auth()->user()->relationship == 'prefer_not_to_say' ? 'selected' : '' }} value="prefer_not_to_say">{{ __('Prefer not to say') }}</option>
                                 <option {{ auth()->user()->relationship == 'other' ? 'selected' : '' }} value="other">{{ __('Other') }}</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="pb-4">
                           <div class="row g-2">
                              <div class="col-md">
                                 <label for="name" class="form-label mb-1">{{__('Language')}}</label>
                                 <select class="select2" name="language" multiple="multiple" style="width:100%;">
                                 @foreach ($languages as $language)
                                 <option value="{{ $language->name }}" {{ $language->name == auth()->user()->language ? 'selected' : '' }}>{{ $language->name }}</option>
                                 @endforeach
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="pb-4">
                           <div class="row g-2">
                              <div class="col-md">
                                 <label for="gender" name="gender" class="form-label mb-1">{{ __('Gender') }}</label>
                                 <select class="form-select form-control" name="gender" style="width:100%;">
                                 <option {{ auth()->user()->gender == 'male' ? 'selected' : '' }} value="male">{{ __('Male') }}</option>
                                 <option {{ auth()->user()->gender == 'female' ? 'selected' : '' }} value="female">{{ __('Female') }}</option>
                                 <option {{ auth()->user()->gender == 'transgender' ? 'selected' : '' }} value="transgender">{{ __('Transgender') }}</option>
                                 <option {{ auth()->user()->gender == 'non-conforming' ? 'selected' : '' }} value="non-conforming">{{ __('Non-Conforming') }}</option>
                                 <option {{ auth()->user()->gender == 'prefer_not_to_say' ? 'selected' : '' }} value="prefer_not_to_say">{{ __('Prefer not to say') }}</option>
                                 <option {{ auth()->user()->gender == 'other' ? 'selected' : '' }} value="other">{{ __('Other') }}</option>                          
                                 </select>
                              </div>
                              <div class="col-md">
                                 <div>
                                    <label for="b-date" class="form-label mb-1">{{ __('Date Of Birth') }}</label>
                                    <input type="date" name="dob" max="{{ Carbon\Carbon::now(env('timezone'))->format('Y-m-d') }}" class="form-control" id="b-date" value="{{ auth()->user()->dob }}">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="pb-4">
                           <div class="row g-2">
                              <div class="col-md">
                                 <label for="name" class="form-label mb-1">{{__('Write a brief description of your issue that you are seeking help for?')}}</label>
                                 <textarea name="note" class="form-control"></textarea>
                              </div>
                           </div>
                        </div>
                        <div class="pb-4">
                           <div class="row g-2">
                              <div class="col-md">
                                 <label for="name" class="form-label mb-1">Which format would you prefer for your session?</label>
                                 <label class="form-control"><input type="checkbox" name="is_video_enable" value="1"> Video</label>
                                 <label class="form-control"><input type="checkbox" name="is_audio_enable" value="1"> Audio</label>
                                 <label class="form-control"><input type="checkbox" name="is_chat_enable" value="1"> Chat</label>
                              </div>
                           </div>
                        </div>
                        <div class="d-flex  Appointment-detail">
                           <button type="submit" class="btn ms-auto">{{ __('Submit') }}</button>
                        </div>
                     </form>
                  </div>
               </div>

         <!-- <div class="disp-none h-100" id="user-sessions">
                  <div class="m-2 profile-side-bar p-3 pt-0 h-100 pb-2 bg-white">
                     <div class="single-nav">
                        <ul class="d-flex justify-content-center border-bottom">
                           <li class="d-flex text-center active">
                              <a href="javascript:void(0)" onclick="seeData('#UpcomingAppointments')" class="h-100 w-100">Upcoming Sessions</a>
                           </li>
                           <li class="d-flex text-cente">
                              <a href="javascript:void(0)" class="h-100 w-100" onclick="seeData('#CompletedAppointments')">{{ __('Completed Sessions') }}</a>
                           </li>
                        </ul>
                     </div>
                     <div>
                        <div class="disp-block" id="UpcomingAppointments">
                           <div class="card card-table mb-0">
                              <div class="card-body user_profile_body">
                                 <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0 datatable">
                                       <thead>
                                          <tr>
                                             <th>#</th>
                                             <th>{{ __('Appoitment Id') }}</th>
                                             <th>{{ __('Therapist Name') }}</th>
                                             <th>{{ __('Appointment date') }}</th>
                                             <th>Total Session</th>
                                             <th>Pending Session</th>
                                             <th>{{ __('Amount') }}</th>
                                             <th>{{ __('Status') }}</th>
                                             <th>{{ __('Sessions') }}</th>
                                             <th>{{ __('Attachments') }}</th>
                                             <th>{{ __('Action') }}</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach ($appointments as $appointment)
                                          @if ($appointment->appointment_status == 'pending' || $appointment->appointment_status == 'PENDING' || $appointment->appointment_status == 'approve' || $appointment->appointment_status == 'APPROVE' || $appointment->pendingsessions() !=0)
                                          @php 
                                          if($appointment->zoom){
                                             $zoomobj = json_decode($appointment->zoom,true);
                                             $zoomurl = $zoomobj['meta']['join_url'];
                                          }else{
                                             $zoomurl='';
                                          }
                                          @endphp
                                          <tr>
                                             <td>{{ $loop->iteration }}</td>
                                             <td>{{ $appointment->appointment_id }}</td>
                                             <td>{{$appointment->doctor->name ?? ''}}</td>
                                             <td>{{ $appointment->date ?? ''}}
                                                <span class="d-block text-info">{{ $appointment->time ?? ''}}</span>
                                             </td>

                                             <td>{{$appointment->totalsessions()}}</td>
                                             <td>{{$appointment->pendingsessions()}}</td>

                                             <td>{{ $currency }}{{ $appointment->amount }}</td>
                                             <td>
                                                @if($appointment->appointment_status == 'pending' || $appointment->appointment_status == 'PENDING')
                                                <span class="badge badge-pill bg-warning">{{__('Pending')}}</span>
                                                @endif
                                                @if($appointment->appointment_status == 'approve' || $appointment->appointment_status == 'APPROVE')
                                                <span class="badge badge-pill bg-success">{{__('Approve')}}</span>
                                                @endif
                                             </td>
                                             <td>
                                                <a onclick="show_sessions({{ $appointment->id }})" class="text-warning"><span>{{__('View Sessions')}}</span>             
                                                </a>
                                             </td>
                                             <td>
                                                <a href="#add_attachments" onclick="appointId({{ $appointment->id }})" class="btn-primary btn btn-sm" data-bs-toggle="modal" style="display: block ruby;"><span>{{__('Upload')}}</span></a>
                                                <a href="#view_attachments" onclick="view_attachments({{ $appointment->id }})" data-bs-toggle="modal" class="text-success">
                                                   {{__(' View')}}
                                                </a>
                                             </td>
                                             <td class="w-100">
                                                <div class="d-flex">
                                                   <a onclick="show_appointment({{ $appointment->id }})" class="btn-primary btn btn-sm" href="javascript:void(0)" role="button" data-from="add_new" data-bs-toggle="modal" data-bs-target="#user_appointment">
                                                      {{__('View')}}
                                                   </a>


                                                <a href="{{$zoomurl}}" class="btn-secondary btn btn-sm  ml-2" ><span class="d-flex"><i class="fa fa-video mx-2 mt-1"></i>{{__(' Call')}}</span></a>



                                                   @if ($appointment->appointment_status != 'cancel' && $appointment->appointment_status != 'complete')
                                                   <a href="#cancel_reason" onclick="appointId({{ $appointment->id }})" class="btn btn-sm btn-danger  ml-2 d-flex justify-content-between"  href="javascript:void(0)" role="button" data-bs-toggle="modal" data-bs-target="#cancel_reason">{{__('Cancel') }}</a>
                                                   @endif
                                                </div>
                                             </td>
                                          </tr>
                                          @endif
                                          @endforeach
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="disp-none" id="CompletedAppointments">
                           <div class="card card-table mb-0">
                              <div class="card-body user_profile_body">
                                 <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0 datatable">
                                       <thead>
                                          <tr>
                                             <th>#</th>
                                             <th>{{ __('Appoitment Id') }}</th>
                                             <th>{{ __('Therapist Name') }}</th>
                                             <th>{{ __('Appointment date') }}</th>

                                             <th>Total Session</th>
                                             <th>Pending Session</th>

                                             <th>{{ __('Amount') }}</th>
                                             <th>{{ __('Status') }}</th>
                                             <th>{{ __('Attachments') }}</th>
                                             <th>{{ __('Action') }}</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach ($appointments as $appointment)
                                          @if ($appointment->appointment_status == 'cancel' || $appointment->appointment_status == 'CANCEL' || $appointment->appointment_status == 'complete' || $appointment->appointment_status == 'COMPLETE' || $appointment->pendingsessions() ==0 )
                                          <tr>
                                             <td>{{ $loop->iteration }}</td>
                                             <td>{{ $appointment->appointment_id }}</td>
                                             <td>
                                                {{$appointment->doctor->name ?? ''}}
                                             </td>
                                             <td>{{ $appointment->date }}
                                                <span class="d-block text-info">{{ $appointment->time }}</span>
                                             </td>

                                             <td>{{$appointment->totalsessions()}}</td>
                                             <td>{{$appointment->pendingsessions()}}</td>

                                             <td>{{ $currency }}{{ $appointment->amount }}</td>
                                             <td>
                                                @if($appointment->appointment_status == 'cancel' || $appointment->appointment_status == 'CANCEL')
                                                <span class="badge badge-pill bg-danger">{{__('Cancelled')}}</span>
                                                @endif
                                                @if($appointment->appointment_status == 'complete' || $appointment->appointment_status == 'COMPLETE')
                                                <span class="badge badge-pill bg-info">{{__('Complete')}}</span>
                                                @endif
                                             </td>
                                             <td>
                                                <a href="#view_attachments" onclick="view_attachments({{ $appointment->id }})" data-bs-toggle="modal" class="text-success ml-2">
                                                   {{__(' View Documents')}}
                                                </a>
                                             </td>
                                             <td class="w-100">
                                                <div class="d-flex">
                                                   <a onclick="show_appointment({{ $appointment->id }})" class="text-info ml-2" href="javascript:void(0)" role="button" data-from="add_new" data-bs-toggle="modal" data-bs-target="#user_appointment">
                                                   {{__('View')}}
                                                   </a>
                                                   @if ($appointment->appointment_status == 'complete' || $appointment->appointment_status == 'cancel')
                                                   @if ($appointment->isReview == false)
                                                   <a onclick="appointId({{ $appointment->id }})" class="text-success ml-2 d-flex" href="javascript:void(0)" role="button" data-from="add_new" data-bs-toggle="modal" data-bs-target="#add_review">
                                                   {{ __(' Review') }}
                                                   </a>
                                                   @endif
                                                   @endif
                                                </div>
                                             </td>
                                          </tr>
                                          @endif
                                          @endforeach
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="disp-none h-100" id="session-details">
                  <div class="m-2 profile-side-bar p-3  pb-2 bg-white h-100">
                     <button class="btn btn-secondary mb-2" onclick="seeData('#user-sessions')"><i class="fa fa-arrow-left"></i> Back</button>
                     <div class="table-responsive">
                        <table class="table table-hover table-center mb-0 session-details">
                           <thead>
                              <tr>
                                 <th>#</th>
                                 <th>Appointment Id</th>
                                 <th>Status</th>
                                 <th>Appointment at</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div> -->
               <div class="disp-none h-100" id="user-sessions" >
                  <div class="m-2 profile-side-bar p-3 pt-0 h-100 pb-2 bg-white">
                     <div class="single-nav">
                        <ul class="d-flex justify-content-center border-bottom">
                           <li class="d-flex text-center active">
                              <a href="javascript:void(0)" onclick="seeData('#UpcomingAppointments')" class="h-100 w-100">Upcoming Sessions</a>
                           </li>
                           <li class="d-flex text-cente">
                              <a href="javascript:void(0)" class="h-100 w-100" onclick="seeData('#CompletedAppointments')">{{ __('Completed Sessions') }}</a>
                           </li>
                        </ul>
                     </div>
                     <div>
                        <div class="disp-block" id="UpcomingAppointments">
                           <div class="card card-table mb-0">
                              <div class="card-body user_profile_body">
                                 <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0 datatable">
                                       <thead>
                                          <tr>
                                             <th>#</th>
                                             <th>{{ __('Appoitment Id') }}</th>
                                             <th>{{ __('Session Id') }}</th>
                                             <th>{{ __('Therapist Name') }}</th>
                                             <th>{{ __('Appointment date') }}</th>
                                             <th>{{ __('Status') }}</th>
                                             <th>{{ __('Attachments') }}</th>
                                             <th>{{ __('Action') }}</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach ($sessions as $session)
                                          @if ($session->session_status != 'complete' && $session->session_status != 'COMPLETE')
                                          <tr>
                                             <td>{{ $loop->iteration }}</td>
                                             <td>{{ $session->appointment_id }}</td>
                                             <td>{{ $session->id }}</td>
                                             <td>{{ $session->doctor->name ?? '' }}</td>  
                                             <td>{{ $session->session_date ?? '' }}
                                                <span class="d-block text-info">{{ $session->session_timeslot ?? '' }}</span>
                                             </td>
                                             <td>
                                                @if($session->session_status == 'pending' || $session->session_status == 'PENDING')
                                                <span class="badge badge-pill bg-warning">{{__('Pending')}}</span>
                                                @endif
                                                @if($session->session_status == 'approve' || $session->session_status == 'APPROVE')
                                                <span class="badge badge-pill bg-success">{{__('Approve')}}</span>
                                                @endif
                                                @if($session->session_status == 'booked')
                                                <span class="badge badge-pill bg-success">{{__('Approval Pending')}}</span>
                                                @endif
                                             </td>
                                             <td>
                                                <a href="#add_attachments" onclick="appointId({{ $session->appointment->id }}, {{ $session->id }})" class="btn-primary btn btn-sm" data-bs-toggle="modal" style="display: block ruby;"><span>{{__('Upload')}}</span></a>
                                                <a href="#view_attachments" onclick="view_attachments({{ $session->appointment->id }})" data-bs-toggle="modal" class="text-success">
                                                   {{__(' View')}}
                                                </a>
                                             </td>
                                             <td class="w-100">
                                                <div class="d-flex">
                                                   <a onclick="show_appointment({{ $session->appointment->id }}, {{ $session->id }})" class="btn-primary btn btn-sm" href="javascript:void(0)" role="button" data-from="add_new" data-bs-toggle="modal" data-bs-target="#user_appointment">
                                                      {{__('View')}}
                                                   </a>

                        @if ($session->session_status == 'pending' && $session->zoomurl == null)
                                                      <!-- <a onclick="book_session({{ $session->id }}, '{{ $session->appointment_id }}')" href="javascript:void(0)" role="button" data-from="add_new" data-bs-toggle="modal" data-bs-target="#book_session" class="btn-secondary btn btn-sm ml-2">Book Now</a> -->

                                  <a href="{{url('/show-therapist?session_id='. $session->id)}}" class="btn-secondary btn btn-sm ml-2">Book Now</a>



                               @else
                                 <a href="{{$session->zoomurl}}" class="btn-secondary btn btn-sm  ml-2" ><span class="d-flex"><i class="fa fa-video mx-2 mt-1"></i>{{__(' Call')}}</span></a>
                                                      @if ($session->session_status != 'cancel' && $session->session_status != 'complete')
                                                      


                                     <!-- <a href="#cancel_reason" onclick="appointId({{ $session->appointment->id }}, {{ $session->id }})" class="btn btn-sm btn-danger  ml-2 d-flex justify-content-between"  href="javascript:void(0)" role="button" data-bs-toggle="modal" data-bs-target="#cancel_reason">{{__('Cancel') }}</a> -->



                                                      @endif
                                                   @endif
                                                </div>


                                                @if($session->session_status != 'completed' && $session->zoomurl !=null)

                                    <a href="{{url('/show-therapist?session_id='. $session->id)}}" class="btn-secondary btn btn-sm ml-2">Reschedule</a>

                                       @endif

                                             </td>
                                          </tr>
                                          @endif


                                          
                                          @endforeach
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="disp-none" id="CompletedAppointments">
                           <div class="card card-table mb-0">
                              <div class="card-body user_profile_body">
                                 <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0 datatable">
                                       <thead>
                                          <tr>
                                             <th>#</th>
                                             <th>{{ __('Appoitment Id') }}</th>
                                             <th>{{ __('Therapist Name') }}</th>
                                             <th>{{ __('Appointment date') }}</th>
                                             <th>{{ __('Status') }}</th>
                                             <th>{{ __('Attachments') }}</th>
                                             <th>{{ __('Action') }}</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach ($sessions as $session)
                                          @if ($session->session_status == 'complete' || $session->session_status == 'COMPLETE')
                                          <tr>
                                             <td>{{ $loop->iteration }}</td>
                                             <td>{{ $session->appointment_id }}</td>
                                             <td>
                                                {{$session->id}}
                                             </td>
                                             <td>
                                                {{$session->doctor->name ?? ''}}
                                             </td>
                                             <td>{{ $session->session_date }}
                                                <span class="d-block text-info">{{ $session->session_timeslot }}</span>
                                             </td>
                                             <td>
                                                @if($session->session_status == 'cancel' || $session->session_status == 'CANCEL')
                                                <span class="badge badge-pill bg-danger">{{__('Cancelled')}}</span>
                                                @endif
                                                @if($session->session_status == 'complete' || $session->session_status == 'COMPLETE')
                                                <span class="badge badge-pill bg-info">{{__('Complete')}}</span>
                                                @endif
                                             </td>
                                             <td>
                                                <a href="#view_attachments" onclick="view_attachments({{ $session->id }})" data-bs-toggle="modal" class="text-success ml-2">
                                                   {{__(' View Documents')}}
                                                </a>
                                             </td>
                                             <td class="w-100">
                                                <div class="d-flex">
                                                   <a onclick="show_appointment({{ $session->appointment->id }}, {{ $session->id}})" class="text-info ml-2" href="javascript:void(0)" role="button" data-from="add_new" data-bs-toggle="modal" data-bs-target="#user_appointment">
                                                   {{__('View')}}
                                                   </a>
                                                   @if ($session->session_status == 'complete' || $session->session_status == 'cancel')
                                                   @if ($session->isReview == false)
                                                   <a onclick="appointId({{ $session->appointment->id }}, {{ $session->id }})" class="text-success ml-2 d-flex" href="javascript:void(0)" role="button" data-from="add_new" data-bs-toggle="modal" data-bs-target="#add_review">
                                                   {{ __(' Review') }}
                                                   </a>
                                                   @endif
                                                   @endif
                                                </div>
                                             </td>
                                          </tr>
                                          @endif
                                          @endforeach
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="disp-none h-100" id="user-changePass">
                  <div class="m-2 profile-side-bar p-3 pt-5 h-100 pb-2 bg-white">
                     <form action="{{ url('change_password') }}" method="post" class="h-100">
                        @csrf
                        <div class="mb-4">
                           <label for="old_pass" class="form-label mb-1">{{ __('Old Password') }}</label>
                           <input type="password" class="form-control" name="old_password" id="old_pass">
                        </div>
                        <div class="mb-4">
                           <label for="new_pass" class="form-label mb-1">{{ __('New Password') }}</label>
                           <input type="password" class="form-control" name="new_password">
                        </div>
                        <div class="mb-4">
                           <label for="conf_new_pass" class="form-label mb-1">{{ __('Confirm new Password') }}</label>
                           <input type="password" class="form-control" name="confirm_new_password" id="conf_new_pass">
                        </div>
                        <div class="d-flex pt-5 Appointment-detail">
                           <button type="submit" class="btn ms-auto">{{ __('Change password') }}</button>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="disp-none h-100" id="user-delete">
                  <div class="m-2 profile-side-bar p-3 pt-5 h-100 pb-2 bg-white">
                     <form action="{{ url('change_password') }}" method="post" class="h-100">
                        @csrf
                        <p>Confirm To Delete Your Account ?</p>
                        <input type="hidden" name="delete" value="1">
                        <div class="d-flex pt-5 Appointment-detail">
                           <button type="submit" class="btn ms-auto">Confirm</button>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="disp-none h-100" id="feedback">
                  <div class="card card-table mb-0">
                     <div class="card-body user_profile_body">
                        <div class="table-responsive">
                           <table class="table table-hover table-center mb-0 datatable">
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th>{{ __('Appoitment Id') }}</th>
                                    <th>{{ __('Session Id') }}</th>
                                    <th>{{ __('Therapist Name') }}</th>
                                    <th>{{ __('Appointment date') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Review') }}</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach ($sessions as $session)
                                 <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $session->appointment_id }}</td>
                                    <td>{{ $session->id }}</td>
                                    <td>
                                       {{$session->doctor->name ?? ''}}
                                    </td>
                                    <td>{{ $session->session_date }}
                                       <span class="d-block text-info">{{ $session->session_timeslot }}</span>
                                    </td>
                                    <td>
                                       @if($session->session_status == 'pending' || $session->session_status == 'PENDING')
                                       <span class="badge badge-pill bg-warning">{{__('Pending')}}</span>
                                       @endif
                                       @if($session->session_status == 'booked')
                                       <span class="badge badge-pill bg-warning">{{__('Approval Pending')}}</span>
                                       @endif
                                       @if($session->session_status == 'approve' || $session->session_status == 'APPROVE')
                                       <span class="badge badge-pill bg-success">{{__('Approve')}}</span>
                                       @endif
                                       @if($session->session_status == 'cancel' || $session->session_status == 'CANCEL')
                                       <span class="badge badge-pill bg-danger">{{__('Cancelled')}}</span>
                                       @endif
                                       @if($session->session_status == 'complete' || $session->session_status == 'COMPLETE')
                                       <span class="badge badge-pill bg-info">{{__('Complete')}}</span>
                                       @endif
                                    </td>
                                    <td class="w-100">
                                       <div class="d-flex">
                                          <a onclick="appointId({{ $session->appointment->id }},{{ $session->id }} ,'{{ $session->doctor->name ?? ''}}')" class="text-success ml-2 d-flex" href="javascript:void(0)" role="button" data-from="add_new" data-bs-toggle="modal" data-bs-target="#add_review">
                                          {{ __(' Review') }}
                                          </a>
                                       </div>
                                    </td>
                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="disp-none h-100" id="chatdiv">
                  <div class="m-2 profile-side-bar p-3 h-100 pb-2 bg-white">
                     <div class="row">
                        <div class="col-lg-4 col-4">
                           <div class="input-group-overlay input-group-sm mb-1">
                              <input style="background: aliceblue; border-radius: 15px" placeholder="Search user"
                                 class="cz-filter-search form-control form-control-sm appended-form-control"
                                 type="text" id="search-conversation-user" autocomplete="off">
                           </div>
                           <!-- Card -->
                           <div class="card mb-3 mb-lg-5">
                              <!-- Body -->
                              <div class="card-body p-md-4 p-2" style="overflow-y: scroll;height: 600px"
                                 id="conversation_sidebar">
                                 <div class="border-bottom"></div>
                                 @php($array=[])
                                 @foreach($conversations as $conv)

                                 @if(in_array($conv->to_user_id,$array)==false)

                                 @php(array_push($array,$conv->to_user_id))

                                 @php($user=\App\Models\User::find($conv->to_user_id))


                                 @if(isset($user) && $user != auth()->user())

                                 @php($unchecked=0)
                                 <!-- \App\Models\Conversation::where(['user_id'=>$conv->user_id,'checked'=>0])->count() -->
                                 <div
                                    class="sidebar_primary_div d-flex border-bottom pb-2 pt-2 pl-md-1 pl-0 justify-content-between align-items-center customer-list {{$unchecked!=0?'conv-active':''}}"
                                    onclick="viewConvs('{{route('admin.message.view',[$conv->to_user_id])}}', 'customer-{{$conv->to_user_id}}')"
                                    style="cursor: pointer; border-radius: 10px;margin-top: 2px;"
                                    id="customer-{{$conv->to_user_id}}">
                                    <div class="avatar avatar-lg avatar-circle">
                                       <img class="avatar-img" style="width: 54px;height: 54px"
                                          src="{{asset('/images/upload/'.$user['image'])}}"
                                          onerror=""
                                          >
                                    </div>
                                    <h6 class="sidebar_name mb-0 mr-3 d-none d-md-block">
                                       {{$user['name']}}
                                       <span class="{{$unchecked!=0?'badge badge-info':''}}" id="counter-{{$conv->user_id}}">{{$unchecked!=0?$unchecked:''}}</span>
                                    </h6>
                                 </div>
                                 @endif
                                 @endif
                                 @endforeach
                              </div>
                              <!-- End Body -->
                           </div>
                           <!-- End Card -->
                        </div>
                        <div class="col-lg-8 col-8 pl-0 pl-md-3" id="view-conversation">
                           <center style="margin-top: 10%">
                              <h4 style="color: rgba(113,120,133,0.62)">View Conversation</h4>
                           </center>
                           {{--view here--}}
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header border-0">
            <h5 class="modal-title" id="exampleModalLabel">{{ __('User Address') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form action="{{ url('addAddress') }}" method="post">
               @csrf
               <input type="hidden" name="from">
               <input type="hidden" name="id">
               <input type="hidden" name="lat" id="lat" value="22.3039">
               <input type="hidden" name="lang" id="lng" value="70.8022">
               <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
               <div id="map" class="mapClass"></div>
               <div class="form-group">
                  <textarea name="address" cols="30" class="form-control" rows="10">{{ __('Rajkot , Gujrat') }}</textarea>
               </div>
               <div class="modal-footer border-0">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                  <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="user_appointment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">{{ __('Appointment') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <table class="table">
               <tr>
                  <td>{{ __('appointment Id') }}</td>
                  <td class="appointment_id"></td>
               </tr>
               <tr>
                  <td>{{ __('Therapist name') }}</td>
                  <td class="doctor_name"></td>
               </tr>
               <tr>
                  <td>{{ __('Client name') }}</td>
                  <td class="patient_name"></td>
               </tr>
               <tr>
                  <td>{{ __('Client address') }}</td>
                  <td class="patient_address"></td>
               </tr>
               <tr>
                  <td>{{ __('Client age') }}</td>
                  <td class="patient_age"></td>
               </tr>
               <tr>
                  <td>{{ __('date') }}</td>
                  <td class="date"></td>
               </tr>
               <tr>
                  <td>{{ __('time') }}</td>
                  <td class="time"></td>
               </tr>
               <tr>
                  <td>{{ __('payment status') }}</td>
                  <td class="payment_status"></td>
               </tr>
               <tr>
                  <td>{{ __('payment type') }}</td>
                  <td class="payment_type"></td>
               </tr>
               <tr>
                  <td>{{ __('Mental health conditions that you have been diagnosed with') }}</td>
                  <td class="illness_info"></td>
               </tr>
            </table>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="test_report" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">{{ __('Test Report') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <table class="table">
               <tr>
                  <td>{{ __('Report Id') }}</td>
                  <td class="report_id"></td>
               </tr>
               <tr>
                  <td>{{ __('Client name') }}</td>
                  <td class="patient_name"></td>
               </tr>
               <tr>
                  <td>{{ __('Client phone number') }}</td>
                  <td class="patient_phone"></td>
               </tr>
               <tr>
                  <td>{{ __('Client age') }}</td>
                  <td class="patient_age"></td>
               </tr>
               <tr>
                  <td>{{ __('Client gender') }}</td>
                  <td class="patient_gender"></td>
               </tr>
               <tr>
                  <td>{{ __('amount') }}</td>
                  <td class="amount"></td>
               </tr>
               <tr>
                  <td>{{ __('payment status') }}</td>
                  <td class="payment_status"></td>
               </tr>
               <tr>
                  <td>{{ __('payment type') }}</td>
                  <td class="payment_type"></td>
               </tr>
               <tr class="pathology_category_id">
                  <td>{{ __('Pathology category') }}</td>
                  <td class="pathology_category"></td>
               </tr>
               <tr class="radiology_category_id">
                  <td>{{ __('Radiology category') }}</td>
                  <td class="radiology_category"></td>
               </tr>
               <table class="table types">
               </table>
            </table>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="purchased_medicine" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">{{ __('Purchased Medicine') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <table class="table">
               <tbody>
                  <tr>
                     <td>{{__('shipping At')}}</td>
                     <td class="shippingAt"></td>
                  </tr>
                  <tr class="shippingAddressTr">
                     <td>{{__('shipping Adddress')}}</td>
                     <td class="shippingAddress"></td>
                  </tr>
                  <tr class="shippingAddressTr">
                     <td>{{__('Delivery Charge')}}</td>
                     <td class="deliveryCharge"></td>
                  </tr>
               </tbody>
            </table>
            <table class="table">
               <thead>
                  <th>{{__('medicine name')}}</th>
                  <th>{{__('medicine qty')}}</th>
                  <th>{{__('medicine price')}}</th>
               </thead>
               <tbody  class="tbody">
               </tbody>
            </table>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="add_review" tabindex="-1" aria-labelledby="add_reviewLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header border-0">
            <h5 class="modal-title" id="exampleModalLabel">{{ __('Review') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form action="{{ url('/addReview') }}" method="post" id="reviewForm">
               @csrf
               <div class="row">
                  <div class="col-lg-12">
                     <input type="hidden" name="appointment_id" value="">
                     <input type="hidden" name="session_id" value="">
                     <div id="doctor_name"> 
                        <label class="col-form-label">{{ __('Doctor Name') }}</label>
                        <input type="text" class="form-control" name="doctor_name" id="doctor_name" value="" readonly>
                     </div>
                     <label class="col-form-label">{{ __('Rate The Session') }}</label>
                     <div id="full-stars-example-two">
                        <div class="rating-group">
                           <input disabled checked class="rating__input rating__input--none" name="rate" id="rating3-none" value="0" type="radio">
                           <label aria-label="1 star" class="rating__label" for="rating3-1"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                           <input class="rating__input" name="rate" id="rating3-1" value="1" type="radio">
                           <label aria-label="2 stars" class="rating__label" for="rating3-2"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                           <input class="rating__input" name="rate" id="rating3-2" value="2" type="radio">
                           <label aria-label="3 stars" class="rating__label" for="rating3-3"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                           <input class="rating__input" name="rate" id="rating3-3" value="3" type="radio">
                           <label aria-label="4 stars" class="rating__label" for="rating3-4"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                           <input class="rating__input" name="rate" id="rating3-4" value="4" type="radio">
                           <label aria-label="5 stars" class="rating__label" for="rating3-5"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                           <input class="rating__input" name="rate" id="rating3-5" value="5" type="radio">
                        </div>
                        <span class="invalid-div text-danger"><span class="rate"></span></span>
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <label class="col-form-label">{{ __('Comments') }}</label>
                     <div class="form-group">
                        <textarea name="review" class="form-control" cols="30" rows="10"></textarea>
                        <span class="invalid-div text-danger"><span class="review"></span></span>
                     </div>
                  </div>
               </div>
               <div class="modal-footer border-0">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                  <button type="button" onclick="addReview()" class="btn btn-primary">{{ __('Save') }}</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="cancel_reason" tabindex="-1" aria-labelledby="cancel_reasonLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header border-0">
            <h5 class="modal-title" id="exampleModalLabel">{{ __('Review') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form method="post" id="cancelForm">
               @csrf
               <input type="hidden" name="id" value="">
               <input type="hidden" name="session_id" value="">
               <input type="hidden" name="cancel_by" value="user">
               <table class="table">
                  @foreach (json_decode($cancel_reason) as $cancel_reason)
                  <tr>
                     <td>
                        <div class="position-relative d-flex align-items-center my-1 mt-2">
                           <input type="radio" class="d-none custom_radio" id="cod{{$loop->iteration}}" name="payment" onchange="seeData('#codPayment')" checked>
                           <label for="cod{{$loop->iteration}}" class="position-absolute custom-radio"></label>
                           <label for="cod{{$loop->iteration}}" class="ms-4 normal-label">{{$cancel_reason}}</label>
                        </div>
                     </td>
                  </tr>
                  @endforeach
               </table>
               <div class="modal-footer border-0">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                  <button type="button" onclick="cancelAppointment()" class="btn btn-primary">{{ __('Save') }}</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="view_attachments" tabindex="-1" aria-labelledby="view_attachmentsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__("Attachments")}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table attachments">
                </table>
                <span class="attachments-error"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add_attachments" tabindex="-1" aria-labelledby="add_attachmentsLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header border-0">
            <h5 class="modal-title" id="exampleModalLabel">{{ __('Attachments') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form method="post" id="attachmentForm">
               @csrf
               <input type="hidden" name="appointment_id" value="">
               <div class="col-lg-6">
                  <div class="form-group">
                     <label class="col-form-group">{{__('Upload file')}}</label>
                     <br>
                     <div class='attachment-info'>
                        <input class="mt-2" type='file' id="attachment" name="attachment[]" accept=".png, .jpg, .jpeg, .pdf, .doc" />
                     </div>
                  </div>
                  <div class="add-more mt-2">
                     <a href="javascript:void(0);" class="add-attachment"><i class="fa fa-plus-circle"></i>{{__(' Add More')}}</a>
                  </div>
                  <span class="invalid-div text-danger"><span class="attachment"></span></span>
               </div>

               <div class="modal-footer border-0">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                  <button type="button" onclick="uploadDocument()" class="btn btn-primary">{{ __('Save') }}</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="book_session" tabindex="-1" aria-labelledby="book_sessionLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">{{ __('Book Your Session') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form action="{{ url('bookSession') }}" method="post">
               @csrf
               <input type="hidden" name="id" id="session_id">
               <input type="hidden" name="appointment_id" id="appointment_id">


               <select name="doctor_id" class="form-control">
                  @foreach($doctorslist as $singledoctor)
                  <option value="{{$singledoctor['id']}}">{{ $singledoctor['name'] }}</option>
                  @endforeach
               </select>
               <input type="date" id="date" min="{{ Carbon\Carbon::now(env('timezone'))->format('Y-m-d') }}" class="form-control" name="date">
               <div class="mt-2 slotes d-flex timeSlotRow">
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                  <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection
@section('js')
<script src="{{url('assets/js/address.js')}}"></script>
@if (App\Models\Setting::first()->map_key)
<script src="https://maps.googleapis.com/maps/api/js?key={{App\Models\Setting::first()->map_key}}&libraries=places&v=weekly" async></script>
@endif
<script src="{{url('assets/js/all.min.js')}}"></script>
@endsection
