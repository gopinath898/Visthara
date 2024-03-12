@extends('layout.mainlayout',['active_page' => 'single_doctor'])
@section('css')
<link rel="stylesheet" href="{{asset('assets/plugins/datepicker/jquery-ui.min.css')}}">
<style>
   .ui-datepicker-trigger{
   width: 20px;
   position: relative;
   left: 220px;
   bottom: 30px;
   }
</style>
@endsection
@section('title',$doctor->name.' Profile')
@section('content')
<div class="full-content">
   <div class="content px-lg-0 px-2 py-3 mx-auto">
      <div class="row">
         <div class="col-lg-3 col-md-12">
            <div class="courses-details-info">
               <div class="image">
                  <img src="{{ $doctor->fullImage }}" alt="image" class="br-100 content-profile-image">
               </div>
               <ul class="info">
                  <li>

                        <input type="hidden" name="doctor_id" value="{{$doctor->id}}">
                        <h5>{{$doctor->name}}</h5>

                  </li>
                  <li>
                     <div>
                        <span>{{ ucwords($doctor->designation ?? '') }}</span>
                     </div>
                  </li>
                  <li>
                     <div class="align-items-center justify-content-between">
                        <i class="bx bx-video f-30"></i>
                        <i class="bx bxs-message-rounded f-30"></i>
                        <i class="bx bx-volume-full f-30"></i>
                     </div>
                  </li>
                  <li>
                     <div class="align-items-center">
                        <span>Available </span>
                        @if(isset($doctor->todaytimeSlot()[0]['start_time']))
                           {{$doctor->todaytimeSlot()[0]['start_time']}}
                        @endif
                     </div>
                  </li>
                  <li>
                     <div class="align-items-center">
                        <span>Rating</span>
                        @for ($i = 1; $i < 6; $i++) 
                        @if ($i <=$doctor['rate']) 
                        <i class='bx bxs-star active'>
                        </i>
                        @endif
                        @endfor
                     </div>
                  </li>
               </ul>
               <!-- <div class="courses-share">
                  <div class="share-info"> -->
                     <!-- <span>Share This Course</span> -->
                     <!-- <ul class="social-link">
                        <li><a href="https://www.facebook.com/profile.php?id=100089281456031" class="d-block" target="_blank"><i class="bx bxl-facebook"></i></a>
                        </li>
                        <li><a href="https://twitter.com/MyMindDoc" class="d-block" target="_blank"><i class="bx bxl-twitter"></i></a>
                        </li>
                        <li><a href="https://instagram.com/my.minddoctor?igshid=YmMyMTA2M2Y=" class="d-block" target="_blank"><i class="bx bxl-instagram"></i></a>
                        </li>
                     </ul>
                  </div>
               </div> -->
            </div>
         </div>
         <div class="col-lg-9 col-md-12">
            <div class="courses-details-desc">
               <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation"><a class="nav-link active" id="overview-tab"
                     data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview"
                     aria-selected="true">Overview</a></li>
                  <!-- <li class="nav-item" role="presentation"><a class="nav-link" id="curriculum-tab"
                     data-bs-toggle="tab" href="#curriculum" role="tab" aria-controls="curriculum"
                     aria-selected="false" tabindex="-1">Licenses</a></li> -->
                  <li class="nav-item" role="presentation"><a class="nav-link" id="reviews-tab"
                     data-bs-toggle="tab" href="#reviews" role="tab" aria-controls="reviews"
                     aria-selected="false" tabindex="-1">Reviews</a></li>
               </ul>
               <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="overview" role="tabpanel"
                     aria-labelledby="#overview-tab">

                   

                     <div class="row new-overview">
                        <div class="col-12">
                           <h3>About</h3>
                           <p>{{ $doctor->desc }}</p>
                        </div>
                        <div class="col-md-6 col-sm-12 mt-3">
                           <h3 class="d-flex"><div class="tab-icon"><i class="bx bxs-star"></i></div>Specializes In</h3>
                           <p>{{ implode(',', $doctor->specialization) ?? ''}}</p>
                        </div>
                        <div class="col-md-6 col-sm-12 mt-3">
                           <h3 class="d-flex"><div class="tab-icon"><i class="bx bx-loader-circle"></i></div>Therapeutic Expertise</h3>
                           <p>{{ implode(',', $doctor->expertiseArea) ?? ''}}</p>
                        </div>
                        <div class="col-md-6 col-sm-12 mt-3">
                           <h3 class="d-flex"><div class="tab-icon"><i class="bx bxs-message-rounded-dots"></i></div>Speaks</h3>
                           <p>{{ implode(',', $doctor->language) ?? ''}}</p>
                        </div>

                  <form action="{{ url('booking/'.$doctor->id.'/'.Str::slug($doctor->name))}}" method="POST">
                        <div class="col-12 mt-3">
                           @csrf
                           <div class="new-overview"
                           style="border-top: 1px solid grey; margin-top: 20px;margin-left: 0px !important;">
                              <div class="d-flex ">
                                 @php $date=date('Y-m-d')@endphp
                                 <div class="todays_slot"
                                    style="margin-top: 20px;margin-left: 0px !important;">
                                    <input type="hidden" name="session_id" value="@if(isset($request->session_id)){{$request->session_id}}@endif">
                                    <div class="mb-3">
                                       <label for="" class="form-label mb-1">{{__('Please Select Appointment Date
                                       and Timings')}}</label>
                                       <input class="form-control datePicker @error('date') is-invalid @enderror todays_date_slot"
                                          id="date" value="{{ old('date',$date) }}"
                                          min="{{ Carbon\Carbon::now(env('timezone'))->format('Y-m-d') }}"
                                          name="date" onkeypress="return false;">
                                       <span class="invalid-div text-danger"><span class="date"></span></span>
                                    </div>
                                    <div class="">
                                       <div class="mt-2 slotes d-flex timeSlotRow">
                                          


                                          
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              @if($pendingsession>0)
                              <p>Total  Available Sessions : {{$pendingsession}}</p>
                              @endif
                              <div class="courses-btn-box" style="text-align: center;">
                                 <button  class="default-btn" style="color: #ffffff !important">Book Now <!-- <i
                                    class="flaticon-user"></i> -->
                                 </button>
                              </div>


                           </div>
                        </div>
                     </form>
                     </div>
                     
                  </div>
                  <div class="tab-pane fade" id="curriculum" role="tabpanel" aria-labelledby="#curriculum-tab">
                     <div class="courses-curriculum">
                        <h3>License Details</h3>
                        <ul class="row">
                           @if(json_decode($doctor->license))
                           @foreach (json_decode($doctor->license) as $license)
                           <li class="col-md-6 text-center license-details">
                              <a href="#" class="pb-2">
                                 <h5 class="courses-name">Lic. Name: <small>{{ $license->licenseName ?? '' }}</small></h5>
                                 <h5 class="courses-name">Lic. Number: <small>{{ $license->licenseNumber ?? '' }}</small></h5>
                                 <hr class="m-2">
                              </a>
                           </li>
                           @endforeach
                           @endif
                        </ul>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="instructor" role="tabpanel" aria-labelledby="#instructor-tab">
                     <div class="courses-instructor">
                        <div class="row align-items-center">
                           <div class="col-lg-12">
                              <div class="schedule bg-white rounded-3 h-100 ">
                                 <div class="d-flex align-items-center border-bottom p-3">
                                    <i class='bx bx-calendar-plus vid-icon text-center'></i>
                                    <h6 class="ms-2">{{ __('Therapist Availablity') }}</h6>
                                 </div>
                                 <div class="d-flex book-slot shadow-sm">
                                    <div class="w-50 d-flex p-2 align-items-center justify-content-center flex-column border-end"
                                       onclick="seeData('#toDays')">
                                       <p>{{ __('Today') }}</p>
                                       <p class="available">{{ count($today_timeslots) }} {{ __('Slots
                                          Available') }}
                                       </p>
                                    </div>
                                    <div class="w-50 d-flex p-2 align-items-center justify-content-center border-start flex-column"
                                       onclick="seeData('#tomorrows')">
                                       <p>{{ __('Tomorrow') }}</p>
                                       <p class="available">{{ count($tomorrow_timeslots) }} {{ __('Slots
                                          Available') }}
                                       </p>
                                    </div>
                                 </div>
                                 <div class="p-3 todays_slot pt-2 ">
                                    <div id="toDays" class="disp-none disp-block">
                                       <h6 class="mb-3 mt-2">{{ __("Today's Schedule") }}</h6>
                                       <div class="mt-2 slotes d-flex ">
                                          @foreach ($today_timeslots as $today_timeslot)
                                          <div class="m-1 d-flex time {{ $loop->iteration == 1 ? 'active' : '' }} rounded-3">
                                             <form method="POST" action="{{ url('set_time') }}">
                                                @csrf
                                                <input type="hidden" name="doctor_id"
                                                   value="{{$doctor->id}}">
                                                <input type="hidden" name="date"
                                                   value="{{\Carbon\Carbon::today()->format('Y-m-d')}}">
                                                <input type="hidden" name="time"
                                                   value="{{$today_timeslot['start_time']}}">
                                                <button type="submit" class="noBorderbutton">{{
                                                $today_timeslot['start_time'] }}</button>
                                             </form>
                                          </div>
                                          @endforeach
                                       </div>
                                    </div>
                                    <div id="tomorrows" class="disp-none ">
                                       <h6 class="mb-3 mt-2">{{ __('Tomorrow Schedule') }}</h6>
                                       <div class="mt-2 slotes d-flex ">
                                          @foreach ($tomorrow_timeslots as $tomorrow_timeslot)
                                          <div
                                             class="m-1 d-flex time {{ $loop->iteration == 1 ? 'active' : '' }} rounded-3">
                                             <form method="POST" action="{{ url('set_time') }}">
                                                @csrf
                                                <input type="hidden" name="doctor_id"
                                                   value="{{$doctor->id}}">
                                                <input type="hidden" name="date"
                                                   value="{{\Carbon\Carbon::tomorrow()->format('Y-m-d')}}">
                                                <input type="hidden" name="time"
                                                   value="{{ $tomorrow_timeslot['start_time'] }}">
                                                <button type="submit" class="noBorderbutton">{{
                                                $tomorrow_timeslot['start_time'] }}</button>
                                             </form>
                                          </div>
                                          @endforeach
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="#reviews-tab">
                  <div class="courses-reviews">
                     <h3>Reviews</h3>
                  </div>
                  @if($reviews)
                  @foreach ($reviews as $review)
                  <div class="p-3 border rounded-3 mb-2">
                     <div class="review-img d-flex w-100">
                        <div>
                           <img src="{{ $review->user['fullImage'] ?? ''}}" class="rounded-circle me-3" alt="">
                        </div>
                        <div>
                           <div>
                              <h6 class="common_head mb-0">{{ $review->user['name'] }}</h6>
                              <div class="rating d-flex align-items-center">
                                 @for ($i = 1; $i < 6; $i++) 
                                 @if ($i <=$review->rate)
                                 <i class="bx bxs-star active"></i>
                                 @else
                                 <i class="bx bxs-star"></i>
                                 @endif
                                 @endfor
                                 <span class="d-inline-block average-rating">({{$review->rate}})</span>
                              </div>
                           </div>
                           <p class="mt-3">{{ $review->review }}</p>
                           <div class="mt-1">
                              <p class="text-muted">{{ $review->created_at->diffForHumans() }}</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  @endforeach
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
   // alert('ddd')
$(document).ready(function(){
   $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        data:{
            date:'2023-07-05',
            doctor_id:{{$doctor->id}},
        },
        url: base_url + '/displayTimeslot',
        success: function (result)
        {
            $('.timeSlotRow').html('');
            if (result.data.length > 0)
            {
                $.each(result.data, function (key, value) {
                    var select;
                    if(key == 0)
                    {
                        var select = 'active';
                        $('.timeSlotRow').append(`<input type="hidden" name="time" value="${value.start_time}-${value.end_time}">`);
                    }
                    else
                      var select = '';
                    $('.timeSlotRow').append(
                      `<div class="m-1 d-flex time ${select} timing${key} rounded-3" onclick="thisTime(${key}, '${value.start_time}')">`+
                        `<a class="selectedClass${key}" href="javascript:void(0)">${value.start_time}-${value.end_time}</a>`+
                      `</div>`);
                });
            }
            else
            {
                $('.timeSlotRow').html('<strong class="text-danger w-100">At this time therapist is not available please change the date...</strong>');
            }
        },
        error: function (err) {

        }
    });
});
</script>
<script src="{{asset('assets/plugins/datepicker/jquery-ui.min.js')}}"></script>
<script
   src="https://maps.googleapis.com/maps/api/js?key={{ App\Models\Setting::first()->map_key }}&sensor=false&libraries=places"></script>
<script src="{{ url('assets/js/doctor_list.js') }}"></script>
<script src="{{ url('assets/js/appointment.js') }}"></script>
@endsection
