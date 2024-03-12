@extends('layout.mainlayout_admin',['activePage' => 'patients'])

@section('title',__('Buy Subscription'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Buy Subscription'),
        'url' => url('patient'),
        'urlTitle' => __('Client'),
    ])

    @if (session('status'))
        @include('superAdmin.auth.status',['status' => session('status')])
    @endif
    <div class="section_body">
        <div class="card">
            <div class="card-body">
                <form action="{{ url('buySubscription') }}" method="post" enctype="multipart/form-data" onsubmit="return validateGuardianDetails();">
                    @csrf
                    <div>
                        <h5 class="common-heading mb-4">{{ __('Package Details') }}</h5>
                        <div class="pb-4">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">{{__('Package Name')}}<span class="aestric">*</span></label>
                                        <select name="package_id" onchange="setPackageDetails(this)" class="form-control @error('package_id') is-invalid @enderror">
                                            @foreach($subscriptions as $subscription)
                                            <option value="{{ $subscription->id }}">{{$subscription->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">{{__('Package Price')}}</label>
                                        <input type="text" class="form-control" value="{{ $subscriptions[0]->price }}" name="package_price" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">{{__('Discount Amount')}}</label>
                                        <input type="text" class="form-control @error('discount_price') is-invalid @enderror" value="{{ $subscriptions[0]->discountPrice }}" name="discount_price" readonly>
                                        <span class="invalid-div text-danger"><span class="discount_price"></span></span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">{{__('Final Amount')}}</label>
                                        <input type="text" class="form-control @error('amount') is-invalid @enderror" value="{{ $subscriptions[0]->finalAmount }}" name="amount" readonly>
                                        <span class="invalid-div text-danger"><span class="amount"></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="payment_type" value="cash">
                    <input type="hidden" name="payment_status" value="1">
                    <input type="hidden" name="payment_token">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input type="hidden" name="discount_id">
                    <div id="details-screen">
                    <div class="appointment-form">
                        <h5 class="common-heading mb-4">{{ __('Client Details') }}</h5>
                        <div class="pb-4">
                            <div class="row g-2">
                                <div class="col-md">
                                    <div class="form-group h-100 d-flex flex-column w-100  select-Sort">
                                        <label for="" class="form-label mb-2">{{ __('Appointment For') }}</label>
                                        <select name="appointment_for" class="form-control @error('appointment_for') is-invalid @enderror" id="appointment_for">
                                            <option value="my_self">{{__('for me')}}</option>
                                            <option value="other">{{__('Other')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="" class="form-label mb-1">{{__('Client Name')}}</label>
                                        <input type="text" class="form-control @error('patient_name') is-invalid @enderror" value="{{ old('patient_name') }}" name="patient_name">
                                        <span class="invalid-div text-danger"><span class="patient_name"></span></span>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="" class="form-label mb-1">{{__('Current Age')}}</label>
                                        <input type="number" class="form-control @error('age') is-invalid @enderror" min="1" value="{{ old('age') }}" name="age" id="age">
                                        <span class="invalid-div text-danger"><span class="age"></span></span>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="" class="form-label mb-1">{{__('Phone number')}}</label>
                                        <input type="number" min="1" name="phone_no" value="{{ old('phone_no') }}" class="form-control @error('phone_no') is-invalid @enderror" id="phone_no">
                                        <span class="invalid-div text-danger"><span class="phone_no"></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pb-4">
                            <label for="" class="form-label mb-2 form-group">Address</label>
                            <input type="text" name="patient_address" value="{{ old('patient_address') }}" class="form-control  @error('patient_address') is-invalid @enderror" id="patient_address">
                            <span class="invalid-div text-danger"><span class="patient_address"></span></span>
                        </div>
                        <div class="pb-4">
                            <div class="row g-2">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="" class="form-label mb-2">{{__('Have you previously received counselling, psychiatric care, or any other kind of mental health services?')}}</label>
                                        <input type="text" name="drug_effect" value="{{ old('drug_effect') }}"
                                            class="form-control  @error('drug_effect') is-invalid @enderror"
                                            id="drug_effect" placeholder="Yes/No">
                                        <span class="invalid-div text-danger"><span class="drug_effect"></span></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="" class="form-label mb-2">{{ __('Write a brief description of what you are seeking help for') }}<br></label>
                                        <input type="text" class="form-control" name="illness_exists" aria-describedby="emailHelpId" placeholder="what you are seeking help for">
                                        <span class="invalid-div text-danger">
                                            <span class="illness_information"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="" class="form-label mb-2">{{ __('Please mention any mental health conditions that you have been diagnosed with?') }}</label>
                                        <input type="text" class="form-control" name="illness_information"
                                            aria-describedby="emailHelpId" placeholder="Mental health conditions">
                                        <span class="invalid-div text-danger"><span
                                                class="illness_information"></span></span>
                                    </div>
                                </div>
                                <div class="col-12 pt-2">
                                    <div class="form-group">
                                        <label for="" class="form-label mb-2">{{ __('Please mention any medical conditions that you have been diagnosed with?') }}</label>
                                        <input type="text" class="form-control" name="illness_information_taken" aria-describedby="emailHelpId" placeholder="Medical conditions ">
                                        <span class="invalid-div text-danger">
                                            <span class="illness_information"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="mt-2 form-group">
                                        <label for="" class="form-label mb-2">{{__('Any Note For the Therapist ?')}}<span class="aestric">*</span></label>
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
                                    <div class="form-group">
                                        <label for="" class="form-label mb-2">{{ __('Name of parent/legal guardian') }}</label>
                                        <input type="text" class="form-control" name="guardian_name" aria-describedby="emailHelpId"> 
                                        <span class="invalid-div text-danger"><span class="guardian_name"></span></span>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="" class="form-label mb-2">{{ __('Phone Number of parent/legal guardian') }}</label>
                                        <input type="number" class="form-control" name="guardian_phone" aria-describedby="emailHelpId">
                                        <span class="invalid-div text-danger"><span class="guardian_phone"></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="text-right p-2">
                        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
