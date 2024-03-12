@extends('layout.mainlayout',['active_page' => 'booking'])
@section('css')
    <link rel="stylesheet" href="{{asset('assets/plugins/datepicker/jquery-ui.min.css')}}">
    <style>
      .ui-datepicker-trigger{
         width: 20px;
         position: relative;
         left: 220px;
         bottom: 27px;
      }
    </style>
@endsection
@section('title',$doctor->name.__(' appointment booking'))
@section('content')
<div class="page-wrapper">
   <div class="full-content">
      <div class="content px-lg-0 px-2 py-3 mx-auto">
         @if($pendingsession == 0)
         <h3>{{ __('Appointment Booking') }}</h3>
         @endif
         <div class="bg-white mt-3">
            <div class="doc-profile Appointment-detail  bg-white rounded-3 h-100 p-3">
               <!-- Doctor Profile -->
               <input type="hidden" name="currency" value="{{ $setting->currency_code }}">
               <input type="hidden" name="company_name" value="{{$setting->business_name}}">
               <input type="hidden" name="user_name" value="{{ auth()->user()->name }}">
               <input type="hidden" name="email" value="{{ auth()->user()->email }}">
               <input type="hidden" name="phone" value="{{ auth()->user()->phone }}">
               
               <!-- Doctor Profile Over -->
               <!-- Stapper -->
            @if($pendingsession > 0)
            <div class="doc-profile" style="text-align: center;">
                  <p>
                     Your Session Successfully Booked with <b>{{ $doctor['name'] }}</b>
                  </p>

                  <p>
                     Date & Time :  <b>{{ $request->date }} {{ $request->time }}</b>
                  </p>

                  <p>Click Here To : 
                  <a href="{{url('/user_profile')}}" class="btn-primary btn">My Profile</a>
                  </p>
               </div>
            @else

               <div class="d-flex  flex-sm-row flex-column align-items-sm-center">
                  <div class="doc-profile-img book-doc-img  me-3">
                     <img src="{{ $doctor->fullImage }}" alt="">
                  </div>
                  <div class="doct-card  doctor-info mt-sm-0 mt-3">
                     <div class="personalInfo">
                        <div>
                           <h6>{{ $doctor['name'] }}</h6>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="mt-3">
                  <div class="progress-container">
                     <div class="progress" id="progress"></div>
                     <div class="circle progress_active">1</div>
                     <div class="circle">2</div>
                     <div class="circle">3</div>
                     <div class="circle">4</div>
                  </div>
                  <form action="" method="post" enctype="multipart/form-data" id="thisform">
                     @csrf
                     <input type="hidden" name="package_id" id="packageselected" value="@if(isset($subscriptions[0]->id)){{$subscriptions[0]->id}}@endif">
                     <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                     <input type="hidden" name="payment_type" value="Instamojo">
                     <input type="hidden" name="payment_status" value="0">
                     <input type="hidden" name="amount" id="instamojoprice" value="@if(isset($subscriptions[0]->finalAmount)){{$subscriptions[0]->finalAmount}}@endif">
                     <input type="hidden" name="payment_token">
                     <input type="hidden" name="discount_price">
                     <input type="hidden" name="discount_id">
                     <div class="my-3 appointment-form px-2">
                        <div id="step1" class="disp-block">
                           <div class="row justify-content-center">
                              <div class="section-title">
                                 <h4>Choose Our Best <span>Pricing</span></h4>
                              </div>
                              @php $ifirst=1;@endphp
                              @foreach ($subscriptions as $offer)
                              @if($offer->name != "1 Session")
                              <div class="col-lg-4 col-md-4">
                                 <div class="single-pricing-table new-single-pricing-table @if($ifirst==1) newclicked @endif" id="pack{{$offer->id}}">
                                    <div class="pricing-header ">
                                          <h6>{{ ucfirst($offer->name) }}</h6>
                                    </div>
                                    <div class="row" style="text-align: center;display: block;">
                                             <img src="images/{{$offer->name}}.png" style="width: 28%;">
                                    </div>
                                    <div class="pricing-btn"> 
                                             <h5><span>Rs.</span>{{$offer->price}}</h5>
                                    </div>
                                    <div class="pricing-features mt-4">
                                    </div>
                                    <div class="pricing-features pricing-features-description mt-4">
                                          <p style="color: black;">
                                          {!! clean($offer->first_description) !!}
                                          </p>
                                          <br>
                                          <p>
                                          {!! clean($offer->description) !!}
                                          </p>
                                    </div>
                                    <div class="pricing-btn">
                                       <a onclick="selectpackage(this, {{$offer->id}}, {{$offer->price}}, '{{$offer->name}}', {{$offer->finalAmount}}, {{$offer->discountPrice}})" class="pricing-button btn btn-primary rounded-pill" style="width: 50%; background-color:#026B81;">@if($ifirst==1) Selected @else Select @endif</a>
                                    </div>
                                 </div>
                                 @php $ifirst++;@endphp
                              </div>
                              @endif
                              @endforeach
                              @foreach ($subscriptions as $offer)
                              @if($offer->name == "1 Session")
                              <div class="single-session text-center col-lg-12 col-md-12" id="pack{{$offer->id}}">
                                    <div >
                                       <p style="font-size:16px;">Or get a single session at Rs.{{$offer->price}}</p>
                                       <a onclick="selectpackage(this, {{$offer->id}}, {{$offer->price}}, '{{$offer->name}}', {{$offer->finalAmount}}, {{$offer->discountPrice}})" class="pricing-button btn btn-outline-dark">Select</a>
                                    </div>
                              </div>
                              @endif
                              @endforeach
                           </div>
                        </div>

                        <div id="step2" class="disp-none">
                           <div class="appointment-form">
                              <h5 class="common-heading mb-4">{{ __('Client Details') }}</h5>
                              <div class="pb-4">
                                 <div class="row g-2">
                                    <div class="col-md">
                                       <div class="h-100 d-flex flex-column w-100  select-Sort">
                                          <label for="" class="form-label mb-2">{{ __('Appointment For') }}</label>
                                          <select name="appointment_for"
                                             class="form-control @error('appointment_for') is-invalid @enderror"
                                             id="appointment_for">
                                             <option value="my_self">{{__('for me')}}</option>
                                             <option value="other">{{__('Other')}}</option>
                                          </select>
                                       </div>
                                    </div>
                                    
                                 
                                    <div class="col-md">
                                       <div>
                                          <label for="" class="form-label mb-1">{{__('Client Name')}}</label>
                                          <input type="text"
                                             class="form-control @error('patient_name') is-invalid @enderror"
                                             value="{{ old('patient_name') }}" name="patient_name">
                                          <span class="invalid-div text-danger"><span
                                                class="patient_name"></span></span>
                                       </div>
                                    </div>
                                    <div class="col-md">
                                       <div>
                                          <label for="" class="form-label mb-1">{{__('Current Age')}}</label>
                                          <input type="number" class="form-control @error('age') is-invalid @enderror"
                                             min="1" value="{{ old('age') }}" name="age" id="age">
                                          <span class="invalid-div text-danger"><span class="age"></span></span>
                                       </div>
                                    </div>
                                    <div class="col-md">
                                       <div>
                                          <label for="" class="form-label mb-1">{{__('Phone number')}}</label>
                                          <input type="number" min="1" name="phone_no" value="{{ old('phone_no') }}"
                                             class="form-control @error('phone_no') is-invalid @enderror" id="phone_no">
                                          <span class="invalid-div text-danger"><span class="phone_no"></span></span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="pb-4">
                                 <label for="" class="form-label mb-1">Address</label>
                                 <input type="text" name="patient_address" value="{{ old('patient_address') }}" class="form-control  @error('patient_address') is-invalid @enderror" id="patient_address">
                                 <span class="invalid-div text-danger"><span class="patient_address"></span></span>
                              </div>
                              <div class="pb-4">
                                 <div class="row g-2">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="" class="form-label mb-1">{{__('Have you previously received counselling, psychiatric care, or any other kind of mental health services?')}}</label>
                                          <input type="text" name="drug_effect" value="{{ old('drug_effect') }}"
                                             class="form-control  @error('drug_effect') is-invalid @enderror"
                                             id="drug_effect" placeholder="Yes/No">
                                          <span class="invalid-div text-danger"><span class="drug_effect"></span></span>
                                       </div>
                                    </div>


                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="" class="form-label mb-1" style="padding-bottom: 18px;">{{ __('Write a brief description of what you are seeking help for') }}<br></label>
                                          <input type="text" class="form-control" name="illness_exists"
                                             aria-describedby="emailHelpId" placeholder="what you are seeking help for">
                                          <span class="invalid-div text-danger"><span
                                                class="illness_information"></span></span>
                                       </div>
                                    </div>


                                    <div class="col-md-6">
                                       <div>
                                          <label for="" class="form-label mb-1">{{ __('3. Please mention any mental health conditions that you have been diagnosed with?') }}</label>
                                          <input type="text" class="form-control" name="illness_information"
                                             aria-describedby="emailHelpId" placeholder="Mental health conditions">
                                          <span class="invalid-div text-danger"><span
                                                class="illness_information"></span></span>
                                       </div>
                                    </div>




                                    <div class="col-md-6">
                                       <div>
                                          <label for="" class="form-label mb-1">{{ __('Please mention any medical conditions that you have been diagnosed with?') }}</label>
                                          <input type="text" class="form-control" name="illness_information_taken"
                                             aria-describedby="emailHelpId" placeholder="Medical conditions ">
                                          <span class="invalid-div text-danger"><span
                                                class="illness_information"></span></span>
                                       </div>
                                    </div>

                                    <div class="col-md">
                                       <div>
                                          <label for="" class="form-label mb-1">{{__('Any Note For the Therapist ?')}}</label>
                                          <input type="text" value="{{ old('note') }}"
                                             class="form-control @error('note') is-invalid @enderror" name="note"
                                             id="note">
                                          <span class="invalid-div text-danger"><span class="note"></span></span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <h6 class="mb-4">{{ __('For Minors (For clients below the age of 18)') }}</h6>
                              <div class="pb-4">
                                 <div class="row g-2">
                                    <div class="col-md">
                                       <div>
                                          <label for="" class="form-label mb-2">{{ __('Name of parent/legal guardian') }}</label>
                                          <input type="text" class="form-control" name="guardian_name" aria-describedby="emailHelpId"> 
                                          <span class="invalid-div text-danger"><span class="guardian_name"></span></span>
                                       </div>
                                    </div>
                                    <div class="col-md">
                                       <div>
                                          <label for="" class="form-label mb-2">{{ __('Phone Number of parent/legal guardian') }}</label>
                                          <input type="number" class="form-control" name="guardian_phone" aria-describedby="emailHelpId">
                                          <span class="invalid-div text-danger"><span class="guardian_phone"></span></span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div id="step3" class="disp-none">
                           <div class="d-flex ">
                              <div class="todays_slot">
                                 <div class="mb-3">
                                    <label for="" class="form-label mb-1">{{__('Appointment Date')}}</label>
                                    <input class="form-control datePicker @error('date') is-invalid @enderror todays_date_slot"
                                       id="date" value="{{ old('date',$date) }}"
                                       min="{{ Carbon\Carbon::now(env('timezone'))->format('Y-m-d') }}" name="date">                      
                                    <span class="invalid-div text-danger"><span class="date"></span></span>
                                 </div>
                                 <div class="">
                                    <div class="mt-2 slotes d-flex timeSlotRow">
                                       @if (count($timeslots) > 0)
                                       @foreach ($timeslots as $timeslot)
                                       @if(Session::has('time') && Session::has('doctor_id'))
                                       @if (Session::get('doctor_id') == $doctor->id)
                                       <input type="hidden" name="time" value="{{Session::get('time')}}">
                                       @else
                                       <input type="hidden" name="time"
                                          value="{{$loop->iteration == 1 ? $timeslot['start_time'] : ''}}">
                                       @endif
                                       @else
                                       <input type="hidden" name="time"
                                          value="{{$loop->iteration == 1 ? $timeslot['start_time'] : ''}}">
                                       @endif
                                       @if (Session::has('time') && Session::has('doctor_id'))
                                       @if (Session::get('doctor_id') == $doctor->id)
                                       <div
                                          class="m-1 d-flex time timing{{$loop->iteration}} {{ Session::get('time') == $timeslot['start_time'] ? 'active' : '' }} rounded-3"
                                          onclick="thisTime({{ $loop->iteration }}, {{ $timeslot['start_time'] }})">
                                          <a class="selectedClass{{$loop->iteration}}" href="javascript:void(0)">{{
                                             $timeslot['start_time'] }}</a>
                                       </div>
                                       @else
                                       <div
                                          class="m-1 d-flex time timing{{$loop->iteration}} {{ $loop->iteration == 1 ? 'active' : '' }} rounded-3"
                                          onclick="thisTime({{ $loop->iteration }}, {{ $timeslot['start_time'] }})">
                                          <a class="selectedClass{{$loop->iteration}}" href="javascript:void(0)">{{
                                             $timeslot['start_time'] }}</a>
                                       </div>
                                       @endif
                                       @else
                                       <div
                                          class="m-1 d-flex time timing{{$loop->iteration}} {{ $loop->iteration == 1 ? 'active' : '' }} rounded-3"
                                          onclick="thisTime({{ $loop->iteration }}, {{ $timeslot['start_time'] }})">
                                          <a class="selectedClass{{$loop->iteration}}" href="javascript:void(0)">{{
                                             $timeslot['start_time'] }}</a>
                                       </div>
                                       @endif
                                       @endforeach
                                       @else
                                       <strong class="text-danger w-100">{{__('At this time therapist is not
                                          availabel please change the date...')}}</strong>
                                       @endif
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div id="step4" class="disp-none">
                           <div class="row">
                              <div class="col-md-7 col-lg-8">
                                 <div class="m-2 border rounded-3 p-3">
                                    <h6>{{__('Payment Method')}}</h6>
                                    @if ($setting->cod == 1)
                                    <div class="position-relative d-flex align-items-center my-1 mt-2">
                                       <input type="radio" class="d-none custom_radio" value="cod" id="cod" name="payment" checked>
                                       <label for="cod" class="position-absolute custom-radio"></label>
                                       <label for="cod" class="ms-4 normal-label">Proceed With Online Payment</label>
                                    </div>
                                    <img src="/images/upload/insta.jpg" style="width: 30%">
                                    @endif
                                    @if ($setting->paypal == 1)
                                    <div class="position-relative d-flex align-items-center my-1 ">
                                       <input type="radio" class="d-none custom_radio" value="paypal" id="paypal"
                                          name="payment">
                                       <label for="paypal" class="position-absolute custom-radio"></label>
                                       <label for="paypal" class="ms-4 normal-label">{{__('paypal')}}</label>
                                    </div>
                                    @endif
                                    @if ($setting->stripe == 1)
                                    <div class="position-relative d-flex align-items-center my-1 ">
                                       <input type="radio" class="d-none custom_radio" value="stripe" id="stripe"
                                          name="payment">
                                       <label for="stripe" class="position-absolute custom-radio"></label>
                                       <label for="stripe" class="ms-4 normal-label">{{__('Stripe')}}</label>
                                    </div>
                                    @endif
                                    @if ($setting->paystack == 1)
                                    <div class="position-relative d-flex align-items-center my-1 ">
                                       <input type="radio" class="d-none custom_radio" value="paystack" id="paystack"
                                          name="payment">
                                       <label for="paystack" class="position-absolute custom-radio"></label>
                                       <label for="paystack" class="ms-4 normal-label">{{__('Paystack')}}</label>
                                    </div>
                                    @endif
                                    @if ($setting->flutterwave == 1)
                                    <div class="position-relative d-flex align-items-center my-1 ">
                                       <input type="radio" class="d-none custom_radio" value="flutterwave"
                                          id="flutterwave" name="payment">
                                       <label for="flutterwave" class="position-absolute custom-radio"></label>
                                       <label for="flutterwave" class="ms-4 normal-label">{{__('Flutterwave')}}</label>
                                    </div>
                                    @endif
                                    @if($setting->razor == 11)
                                    <div class="position-relative d-flex align-items-center my-1 ">
                                       <input type="radio" class="d-none custom_radio" value="razor" id="razorpay"
                                          name="payment">
                                       <label for="razorpay" class="position-absolute custom-radio"></label>
                                       <label for="razorpay" class="ms-4 normal-label">{{__('Razor Pay')}}</label>
                                    </div>
                                    @endif
                                    <div class="mt-3">
                                       <div id="paypalPayment" class="paypal_row disp-none">
                                          <div class="card">
                                             <div class="paypal_row_body"></div>
                                          </div>
                                       </div>
                                       <div id="stripePayment" class="stripe_row disp-none">
                                          <div class="alert alert-warning stripe_alert hide" role="alert">
                                          </div>
                                          <input type="hidden" name="stripe_publish_key" value="{{App\Models\Setting::find(1)->stripe_public_key}}">
                                          <form role="form" method="post" class="require-validation hide customform"
                                             data-cc-on-file="false" id="stripe-payment-form">
                                             @csrf
                                             <div class="row">
                                                <div class="col-12">
                                                   <div class="form-group">
                                                      <label>{{__('Email')}}</label>
                                                      <input type="email" class="email form-control required"
                                                         title="Enter Your Email" name="email" required />
                                                   </div>
                                                </div>
                                                <div class="col-12">
                                                   <div class="form-group">
                                                      <label>{{__('Card Information')}}</label>
                                                      <input type="text" class="card-number required form-control"
                                                         title="please input only number." pattern="[0-9]{16}"
                                                         name="card-number" placeholder="1234 1234 1234 1234"
                                                         title="Card Number" required />
                                                      <div class="row" class="mt-1">
                                                         <div class="col-lg-6 pr-0">
                                                            <input type="text" class="expiry-date required form-control"
                                                               name="expiry-date" title="Expiration date"
                                                               title="please Enter data in MM/YY format."
                                                               pattern="(0[1-9]|10|11|12)/[0-9]{2}$" placeholder="MM/YY"
                                                               required />
                                                            <input type="hidden"
                                                               class="card-expiry-month required form-control"
                                                               name="card-expiry-month" />
                                                            <input type="hidden"
                                                               class="card-expiry-year required form-control"
                                                               name="card-expiry-year" />
                                                         </div>
                                                         <div class="col-lg-6 pl-0">
                                                            <input type="text" class="card-cvc required form-control"
                                                               title="please input only number." pattern="[0-9]{3}"
                                                               name="card-cvc" placeholder="CVC" title="CVC" required />
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-12">
                                                   <div class="form-group">
                                                      <label>{{__('Name on card')}}</label>
                                                      <input type="text" class="required form-control" name="name"
                                                         title="Name on Card" required />
                                                   </div>
                                                </div>
                                                <div class="col-12">
                                                   <div class="form-group text-center">
                                                      <input type="button" class="btn btn-primary mt-4 btn-submit"
                                                         value="{{ __('Pay with stripe') }}" />
                                                   </div>
                                                </div>
                                             </div>
                                          </form>
                                       </div>
                                       <div id="paystackPayment" class="paystack_row disp-none">
                                          <div class="card-header">{{__('Paystack')}}</div>
                                          <div class="card-body">
                                             <form id="paymentForm">
                                                <input type="hidden" id="paystack-public-key"
                                                   value="{{ App\Models\Setting::find(1)->paystack_public_key }}">
                                                <input type="hidden" id="email-address"
                                                   value="{{ auth()->user()->email }}" required />
                                                <div class="form-submit">
                                                   <input type="button" class="btn btn-primary"
                                                      onclick="payWithPaystack()" value="{{__('Pay with paystack')}}">
                                                </div>
                                             </form>
                                          </div>
                                       </div>
                                       <div id="flutterPayment" class="flutterwave_row disp-none">
                                          <form>
                                             <input type="hidden" name="flutterwave_key"
                                                value="{{ $setting->flutterwave_key }}">
                                             <script src="{{ asset('payment/flutterwave.js') }}"></script>
                                             <div
                                                class="w-full px-4 flex gap-3 items-center mt-5 rounded-md h-auto justify-center">
                                                <input type="button" class="btn btn-primary" onclick="makePayment()"
                                                   value="{{__('Payment With Flutterwave')}}">
                                             </div>
                                          </form>
                                       </div>
                                       <div id="razorPayment" class="razor_row disp-none">
                                          <div class="card-header">{{__('razor pay')}}</div>
                                          <input type="hidden" id="RAZORPAY_KEY" value="{{ $setting->razor_key }}">
                                          <div class="card-body">
                                             <div class="row">
                                                <div class="col-md-12 text-center">
                                                   <input type="button" id="paybtn" value="{{__('pay')}}"
                                                      class="btn btn-primary">
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-5 col-lg-4">
                                 <div class="booking-summery border m-2 rounded-3">
                                    <div class="booking-card-head p-3 border-bottom">
                                       <h6>{{__('Booking Summary')}}</h6>
                                    </div>
                                    <div class="p-3">
                                       <div class="d-flex  flex-sm-row flex-column align-items-sm-center mb-2">
                                          <div class="booking-card-img  me-3">
                                             <img src="{{ $doctor->fullImage }}" alt="">
                                          </div>
                                          <div class="doct-card doctor-info">
                                             <div class="personalInfo">
                                                <div>
                                                   <h6>{{ $doctor->name }}</h6>
                                                </div>
                                                <div class="rating d-flex  align-items-center">
                                                   <i class="bx bxs-star active"></i>
                                                   <i class="bx bxs-star active"></i>
                                                   <i class="bx bxs-star active"></i>
                                                   <i class="bx bxs-star"></i>
                                                   <i class="bx bxs-star"></i>
                                                   <span class="d-inline-block average-rating">(0)</span>
                                                </div>
                                                {{-- <div class="location my-2 d-flex">
                                                   <i class="bx bx-map me-1"></i>

                                                   @foreach ($collection as $item)
                                                   <p>{{ $doctor['hospital']['address'] }}</p>
                                                   @endforeach
                                                </div> --}}
                                             </div>
                                          </div>
                                       </div>

                                       <div class="pb-4 pt-3 border-bottom bill my-2">

                                          <p class="d-flex justify-content-between" id="packagename">{{ __('Package Fee') }}
                                             <span>{{ $setting->currency_symbol }}

                                                <span id="packagefee">@if(isset($subscriptions[0]->price)){{$subscriptions[0]->price}}@endif</span>
                                             </span>
                                          </p>
                                          <p class="d-flex justify-content-between discountLi">{{__('Discount
                                             amount ')}}
                                             <span>{{ $setting->currency_symbol }}
                                                <span class="discountAmount">{{$subscriptions[0]->discountPrice ?? '0'}}</span>
                                             </span>
                                          </p>
                                       </div>
                                       <div class="pt-3 total-bill pb-2 ">
                                          <h5 class="d-flex justify-content-between">{{__('Total')}}
                                             <p>{{ $setting->currency_symbol }}
                                                <span class="finalAmount total-cost">{{isset($subscriptions[0]->finalAmount) ? $subscriptions[0]->finalAmount : 0}}</span>
                                             </p>
                                          </h5>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="d-flex justify-content-between">
                        <button type="button" class="btn" id="prev" disabled>{{ __('Prev') }}</button>
                        <button type="button" class="btn" id="next">{{ __('Next')}}</button>

                        <a href="javascript:void(0)" onclick="booking()" id="payment" class="btn d-none">{{ __('Proceed
                           To Pay') }}</a>
                     </div>
               </div>

            @endif
               <!-- Stapper Over -->
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
               <input type="hidden" name="from" value="add_new">
               <input type="hidden" name="id">
               <input type="hidden" name="lat" id="lat" value="22.3039">
               <input type="hidden" name="lang" id="lng" value="70.8022">
               <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
               <div id="map" class="mapClass"></div>
               <div class="form-group">
                  <textarea name="address" cols="30" class="form-control"
                     rows="10">{{ __('Rajkot , Gujrat') }}</textarea>
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
@endsection
@section('js')
<script src="{{asset('assets/plugins/datepicker/jquery-ui.min.js')}}"></script>
@if (App\Models\Setting::first()->map_key)
<script
   src="https://maps.googleapis.com/maps/api/js?key={{App\Models\Setting::first()->map_key}}&callback=initAutocomplete&libraries=places&v=weekly"
   async></script>
@endif
<script src="{{ url('assets/js/appointment.js') }}"></script>
@if (App\Models\Setting::first()->paypal_sandbox_key)
<script
   src="https://www.paypal.com/sdk/js?client-id={{ App\Models\Setting::first()->paypal_sandbox_key }}&currency={{ App\Models\Setting::first()->currency_code }}"
   data-namespace="paypal_sdk"></script>
@endif
<script src="{{ url('payment/razorpay.js')}}"></script>
<script src="{{ url('payment/stripe.js')}}"></script>
@if(App\Models\Setting::first()->paystack_public_key)
<script src="{{ url('payment/paystack.js') }}"></script>
@endif
@endsection