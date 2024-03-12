@extends('layout.mainlayout_admin',['activePage' => 'doctor'])

@section('title',__('Add Therapist'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Add Therapist'),
        'url' => url('doctor'),
        'urlTitle' =>  __('Therapist'),
    ])
    @if (session('status'))
        @include('superAdmin.auth.status',['status' => session('status')])
    @endif

    <div class="section_body">
        <form action="{{ url('therapy') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header text-primary">
                    {{__('personal information')}}
                </div>
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-lg-2 col-md-4">
                            <label for="Doctor_image" class="col-form-label"> {{__('Therapist image')}}</label>
                            <div class="avatar-upload avatar-box avatar-box-left">
                                <div class="avatar-edit">
                                    <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg" />
                                    <label for="image"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview">
                                    </div>
                                </div>
                            </div>
                            @error('image')
                                <div class="custom_error">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-10 col-md-8">
                            <div class="form-group">
                                <label class="col-form-label">{{__('Name')}}</label>
                                <input type="text" value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">{{__('email')}}</label>
                                <input type="email" value="{{ old('email') }}" name="email" class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-6 form-group">
                            <label for="phone_number" class="col-form-label"> {{__('Phone number')}}</label>
                            <div class="d-flex @error('phone') is-invalid @enderror">
                                <select name="phone_code" class="phone_code_select2">
                                    @foreach ($countries as $country)
                                        <option value="+{{$country->phonecode}}" {{(old('phone_code') == $country->phonecode) ? 'selected':''}}>+{{ $country->phonecode }}</option>
                                    @endforeach
                                </select>
                                <input type="number" min="1" name="phone" class="form-control" value="{{ old('phone') }}">
                            </div>
                            @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 form-group">
                            <label class="col-form-group">{{__('Languages')}}</label>
                            <select name="language[]" class="select2 @error('language') is-invalid @enderror" multiple>
                                @foreach ($languages as $hospital)
                                    <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                                @endforeach
                            </select>
                            @error('language')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    
                        <div class="col-lg-6 form-group">
                            <label class="col-form-label">{{__('Date of birth')}}</label>
                            <input type="text" class="form-control datePicker @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob') }}">
                            @error('dob')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <label class="col-form-label">{{__('Gender')}}</label>
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
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-12 form-group">
                            <label class="col-form-label">{{__('Professional Bio')}}</label>
                            <textarea name="desc" rows="10" cols="10" class="form-control @error('desc') is-invalid @enderror"></textarea>
                            @error('desc')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-6 form-group">
                            <label class="col-form-group">{{__('Designation')}}</label>
                            <input type="text" class="form-control  @error('designation') is-invalid @enderror" name="designation">
                            @error('designation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header text-primary">
                    {{__('Education')}}
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-form-label">{{__('Add Education')}}</label>
                        <div class="education-info">
                            <div class="row form-row education-cont">
                                <div class="col-12 col-md-10 col-lg-11">
                                    <div class="row form-row">
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Name of Degree')}}</label>
                                                <input type="text" required name="degree[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('University')}}</label>
                                                <input type="text" required name="college[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Year of Passing')}}</label>
                                                <input type="text" maxlength="4" pattern="^[0-9]{4}$" required name="year[]" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="add-more">
                            <a href="javascript:void(0);" class="add-education"><i class="fa fa-plus-circle"></i> Add More</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header text-primary">
                    {{__('License')}}
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-form-label">{{__('Add License')}}</label>
                        <div class="license-info">
                            <div class="row form-row license-cont">
                                <div class="col-12 col-md-10 col-lg-11">
                                    <div class="row form-row">
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Name')}}</label>
                                                <input type="text" name="licenseName[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('License Number')}}</label>
                                                <input type="text" name="licenseNumber[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Issued By')}}</label>
                                                <input type="text" name="issuedBy[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Date of Issue')}}</label>
                                                <input type="date" name="issueDate[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Date of Expiration')}}</label>
                                                <input type="date" name="expiryDate[]" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="add-more">
                            <a href="javascript:void(0);" class="add-license"><i class="fa fa-plus-circle"></i> Add More</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header text-primary">
                    {{__('Certification')}}
                </div>   
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-lg-12 form-group">
                            <div class="awards-info">
                                <div class="row form-row awards-cont">
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label>{{__('certificate')}}</label>
                                            <input type="text" name="certificate[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label>{{__('Issued By')}}</label>
                                            <input type="text" name="certificate_issuedBy[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label>{{__('Date of Issue')}}</label>
                                            <input type="date" name="certificate_issueDate[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label>{{__('Date of Expiration')}}</label>
                                            <input type="date" name="certificate_expiryDate[]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="add-more">
                                <a href="javascript:void(0);" class="add-award"><i class="fa fa-plus-circle"></i>{{__(' Add More')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header text-primary">
                    {{__('Experience')}}
                </div>
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-lg-12 form-group">
                            <div class="experience-info">
                                <div class="row form-row experience-cont">
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label class="col-form-group">{{__('Experience (in years)')}}<span class="aestric">*</span></label>
                                            <input type="number" min="1" name="experience_years[]" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label>{{__('Company Name')}}<span class="aestric">*</span></label>
                                            <input type="text" name="company[]" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label>{{__('Job Title')}}<span class="aestric">*</span></label>
                                            <input type="text" name="job_title[]" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label>{{__('Duration')}}<span class="aestric">*</span></label>
                                            <input type="number" min="1" name="duration[]" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label>{{__('Location')}}<span class="aestric">*</span></label>
                                            <input type='text' name="location[]" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label>{{__('Description')}}<span class="aestric">*</span></label>
                                            <input type='text' name="description[]" class="form-control" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="add-more">
                                <a href="javascript:void(0);" class="add-experience"><i class="fa fa-plus-circle"></i>{{__(' Add More')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-6 form-group">
                            <label class="col-form-label">{{__('Areas of Expertise')}}</label>
                            <select name="treatment_id[]" id="treatment_id" class="select2 @error('treatment_id') is-invalid @enderror" multiple>
                                @foreach ($treatments as $treatment)
                                    <option value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                                @endforeach
                            </select>
                            @error('treatment_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 form-group">
                            <label class="col-form-label">{{__('Therapy Specializations')}}</label>
                            <select name="category_id[]" id="category_id" class="select2 @error('category_id') is-invalid @enderror" multiple>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- <div class="col-lg-4 form-group">
                            <label class="col-form-label">{{__('Expertise')}}</label>
                            <select name="expertise_id" class="select2 @error('expertise_id') is-invalid @enderror">
                                @foreach ($expertieses as $experties)
                                    <option value="{{ $experties->id }}">{{ $experties->name }}</option>
                                @endforeach
                            </select>
                            @error('expertise_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> -->
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-6 form-group">
                            <label class="col-form-label">{{__('Timeslots(In minutes)')}}</label>
                            <select name="timeslot" class="form-control @error('timeslot') is-invalid @enderror">
                                <option value="15">15</option>
                                <option value="30">30</option>
                                <option value="45">45</option>
                                <option value="60">60</option>
                                <option value="90">90</option>
                                <option value="other">{{__('Other')}}</option>
                            </select>
                            @error('timeslot')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 form-group">
                            <label class="col-form-label">{{__('Based On')}}</label>
                            <select name="based_on" class="form-control @error('based_on') is-invalid @enderror">
                                <option value="subscription">{{__('subscription')}}</option>
                                <option value="commission">{{__('commission')}}</option>
                            </select>
                            @error('based_on')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-lg-6 form-group custom_timeslot hide">
                            <label class="col-form-label">{{__('Add timeslot value(In minutes)')}}</label>
                            <input type="number" min="1" class="form-control custom_timeslot_text @error('timeslot') is-invalid @enderror">
                            @error('timeslot')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 form-group base_on_com hide">
                            <label class="col-form-label">{{__('Commission Amount ( pr appointment ) ( in % )')}}</label>
                            <input type="number" min="1" name="commission" class="form-control base_on_com_text @error('commission') is-invalid @enderror">
                            @error('commission')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-6 form-group">
                            <label class="col-form-label">{{__('Start Time')}}</label>
                            <input class="form-control timepicker @error('start_time') is-invalid @enderror" name="start_time" value="08.00" type="time">
                            @error('start_time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 form-group">
                            <label class="col-form-label">{{__('End Time')}}</label>
                            <input class="form-control timepicker @error('end_time') is-invalid @enderror" name="end_time" value="20.00" type="time">
                            @error('end_time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-12 form-group    ">
                            <label class="col-form-label">{{__('Popular ?')}}</label>
                            <select name="is_popular" class="form-control">
                                <option value="1">{{__('yes')}}</option>
                                <option value="0">{{__('no')}}</option>
                            </select>
                            @error('is_popular')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="text-right p-2">
                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

