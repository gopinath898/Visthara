@extends('layout.mainlayout_admin',['activePage' => 'login'])

@section('title',__('Therapist Register'))

@section('content')
<section class="section">
    <div class="d-flex flex-wrap align-items-stretch">
      <div class="col-lg-5 col-md-5 col-12 order-lg-1 min-vh-100 order-2 bg-white">
        <div class="p-4 m-3">
          @php
            $app_logo = App\Models\Setting::first();
          @endphp 
          <a href="{{url('/')}}">
          <img src="{{ $app_logo->logo }}" alt="logo" width="180" class="mb-5 mt-2">
            </a>
            @if ($errors->any())
                @foreach ($errors->all() as $item)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $item }}
                    </div>
                @endforeach
            @endif
            <form action="{{ url('doctor/doctor_register') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="email">{{ __('Name') }}</label>
                    <input class="form-control @error('name') is-invalid @enderror"  name="name" value="{{ old('name') }}" type="name">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">{{ __('Email') }}</label>
                    <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" type="email">
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">{{ __('Phone') }}</label>
                    <div class="d-flex @error('phone') is-invalid @enderror">
                        <select name="phone_code" class="phone_code_select2">
                            @foreach ($countries as $country)
                                <option value="+{{$country->phonecode}}" {{(old('phone_code') == $country->phonecode) ? 'selected':''}}>+{{ $country->phonecode }}</option>
                            @endforeach
                        </select>
                        <input type="number" value="{{ old('phone') }}" name="phone" class="form-control">
                    </div>
                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input class="form-control @error('password') is-invalid @enderror" name="password" type="password">
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">{{ __('Date of birth') }}</label>
                    <input type="text" class="form-control datePicker @error('dob') is-invalid @enderror" name="dob">
                    @error('dob')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">{{ __('Gender') }}</label>
                    <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                        <option value="male">{{__('Male')}}</option>
                        <option value="female">{{__('Female')}}</option>
                        <option value="other">{{__('Other')}}</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


               <!--  <div class="form-group">
                    <label for="email">{{ __('Specialist In') }}</label>
                   
                        <select name="phone_code" class="form-control" multiple="multiple">
                            @foreach ($categories as $cat)
                                <option value="">{{$cat->name}}</option>
                            @endforeach
                        </select>
                        
                  
                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div> -->

                <div class="form-group text-right">
                    <span class="float-left">{{__("already have an account?")}}<a href="{{ url('therapy/therapy_login') }}">{{__(' Login')}}</a></span>
                    <button class="btn btn-primary btn-lg btn-icon icon-right" type="submit">{{__('Sign Up')}}</button>
                </div>
            </form>
            <div class="login-or">
                <span class="or-line"></span>
            </div>
        </div>
      </div>


      <div class="col-lg-7 col-12 order-lg-2 order-1 min-vh-100  position-relative main-banner-item" style="padding-top: 80px;background-color: #fbfbfbe5;text-align: center;">
            <h3 style="padding-bottom: 20px;">Why Work With Us?</h3>

        <div class="row" style="text-align: center;">
        <div class="col-md-6">
            <img src="{{asset('assets/images/client.png')}}" alt="image" style="width: 53%;padding: 28px;">
            <h5>Regular Client Flow</h5>
            <p>MMD makes sure there are regular clients available for you so you can concentrate
            on giving the best care.</p>
        </div>

        <div class="col-md-6">
            <img src="{{asset('assets/images/super.png')}}" alt="image" style="width: 40%;padding: 20px;">
            <h5>Supervision</h5>
            <p>Get supervision from licensed clinical psychologists to uphold ethical and legal
            requirements and continuous learning.</p>
        </div>

        <div class="col-md-6">
            <img src="{{asset('assets/images/cn.png')}}" alt="image" style="width: 40%;padding: 20px;">
            <h5>Convenience</h5>
            <p>Flexible working hours and the option of working from anywhere of your choice</p>
        </div>

        <div class="col-md-6">
            <img src="{{asset('assets/images/cost.png')}}" alt="image" style="width: 40%;padding: 20px;">
            <h5>No overhead Costs</h5>
            <p>Eliminate costs such as rent and travel expenses as well as the cost of acquiring new customers</p>
        </div>
        </div>
      </div>
    </div>
  </section>
@endsection