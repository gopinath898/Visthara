@extends('layout.mainlayout',['active_page' => 'booking'])
@section('title',$package->name.__(' appointment booking'))
@section('content')


@php $plans =  json_decode($package->plan);@endphp


<div class="page-wrapper">
   <div class="full-content">
      <div class="content px-lg-0 px-2 py-3 mx-auto" style="text-align: center;">
         <h3>{{ __('Package Booking Checkout ') }}</h3>
         <div class="bg-white mt-3">
            <div class="doc-profile Appointment-detail  bg-white rounded-3 h-100 p-3">
               <!-- Doctor Profile -->
              
               <div id="razorPayment" class="razor_row disp-none">
                  <div class="card-header">{{__('razor pay')}}</div>
                  <input type="hidden" id="RAZORPAY_KEY" value="{{ $setting->razor_key }}">
                  <div class="card-body">
                     <div class="row">
                        <div class="col-md-12 text-center">
                           <input type="button" id="paybtn" value="{{__('pay')}}" class="btn btn-primary">
                        </div>
                     </div>
                  </div>
               </div>
               
               <div class="row" style="text-align: center;align-content: center;display: block ruby;">
                  <div class="col-md-5 col-lg-4">
                     <div class="booking-summery border m-2 rounded-3">
                        <div class="booking-card-head p-3 border-bottom">
                           <h6>{{__('Booking Summary')}}</h6>
                        </div>
                        <div class="p-3">
                           <div
                              class="d-flex  flex-sm-row flex-column align-items-sm-center mb-2">
                           </div>
                           <div class="pb-4 pt-3 border-bottom bill my-2">
                              <p class="d-flex justify-content-between" id="packagename">{{ $package->name }}
                                 <span>{{ $setting->currency_symbol }}
                                    <span  id="packagefee"> {{$plans[0]->price}}</span>
                                 </span>
                              </p>
                              <p class="d-flex justify-content-between discountLi">{{__('Discount amount ')}}
                                 <span>{{ $setting->currency_symbol }}
                                    <span class="discountAmount"></span>
                                 </span>
                              </p>
                           </div>
                           <div class="pt-3 total-bill pb-2 ">
                              <h5 class="d-flex justify-content-between">{{__('Total')}}
                                 <p>{{ $setting->currency_symbol }}
                                    <span class="finalAmount total-cost">{{$plans[0]->price}}</span>
                                 </p>
                              </h5>
                           </div>
                        </div>
                  
                  
                        <div class="d-flex justify-content-between" style="align-content: center;text-align: center;display: ruby !important;">
                     

                           <a href="javascript:void(0)" onclick="booking()" id="payment"  class="btn btn-primary" style="margin-bottom: 14px;">{{ __('Proceed To Pay') }}</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection
@section('js')
@if (App\Models\Setting::first()->map_key)
<script src="https://maps.googleapis.com/maps/api/js?key={{App\Models\Setting::first()->map_key}}&callback=initAutocomplete&libraries=places&v=weekly" async></script>
@endif
<script src="{{ url('assets/js/appointment.js') }}"></script>
@if (App\Models\Setting::first()->paypal_sandbox_key)
<script src="https://www.paypal.com/sdk/js?client-id={{ App\Models\Setting::first()->paypal_sandbox_key }}&currency={{ App\Models\Setting::first()->currency_code }}" data-namespace="paypal_sdk"></script>
@endif
<script src="{{ url('payment/razorpay.js')}}"></script>
<script src="{{ url('payment/stripe.js')}}"></script>
@if(App\Models\Setting::first()->paystack_public_key)
<script src="{{ url('payment/paystack.js') }}"></script>
@endif
@endsection
