@extends('layout.mainlayout_admin',['activePage' => 'therapy'])

@section('title',__('Edit Therapist'))
@section('content')
<style type="text/css">
    .select2-container {
        width:100%;
    }
</style>
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Edit Therapist'),
        'url' => url('therapist'),
        'urlTitle' =>  __('Therapist'),
    ])
    @if (session('status'))
        @include('superAdmin.auth.status',['status' => session('status')])
    @endif
    <form action="{{ url('therapy/'.$doctor->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <div class="card">
            <div class="card-header text-primary">
                {{__('personal information')}}
            </div>
            <div class="card-body">
                <div class="row mt-4">
                    <div class="col-lg-2 col-md-4">
                        <label for="Doctor_image" class="ul-form__label"> {{__('Doctor image')}}</label>
                        <div class="avatar-upload avatar-box avatar-box-left">
                            <div class="avatar-edit">
                                <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg" />
                                <label for="image"></label>
                            </div>
                            <div class="avatar-preview">
                                <div id="imagePreview" style="background-image: url({{ $doctor->fullImage }});">
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

                    <div class="row">
                        <div class="col-lg-2 col-md-2">
                            <div class="form-group">
                                <label class="col-form-label">{{__('Title')}}<span class="aestric">*</span></label>
                                <select name="title" class="form-control"> 
                                    <option value="Mr." {{ $doctor->title == 'Mr.' ? 'selected' : ''}}>Mr.</option>
                                    <option value="Ms." {{ $doctor->title == 'Ms.' ? 'selected' : ''}}>Ms.</option>
                                    <option value="Mrs." {{ $doctor->title == 'Mrs.' ? 'selected' : ''}}>Mrs.</option>
                                    <option value="Dr." {{ $doctor->title == 'Dr.' ? 'selected' : ''}}>Dr.</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">{{__('First Name')}}<span class="aestric">*</span></label>
                                <input type="text" value="{{ $doctor->firstName }}" name="firstName" class="form-control @error('name') is-invalid @enderror" required>
                                @error('firstName')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <label class="col-form-label">{{__('Middle Name')}}</label>
                                <input type="text" value="{{ $doctor->middleName }}" name="middleName" class="form-control @error('name') is-invalid @enderror">
                                @error('middleName')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <label class="col-form-label">{{__('Last Name')}}<span class="aestric">*</span></label>
                                <input type="text" value="{{ $doctor->lastName }}" name="lastName" class="form-control @error('name') is-invalid @enderror" required>
                                @error('lastName')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
    
                        <label class="col-form-label">{{__('email')}}<span class="aestric">*</span></label>
                        <div class="form-group">
                            <input type="email" readonly value="{{ $doctor->user['email'] }}" name="email" class="form-control @error('email') is-invalid @enderror" required>
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
                        <label for="phone_number" class="col-form-label"> {{__('Phone number')}}<span class="aestric">*</span></label>
                        <div class="d-flex">
                            <select name="phone_code" class="phone_code_select2" disabled>
                                @foreach ($countries as $country)
                                    <option value="+{{$country->phonecode}}" {{ $doctor->user['phone_code'] == +$country->phonecode ? 'selected' : '' }}>+{{ $country->phonecode }}</option>
                                @endforeach
                            </select>
                            <input type="number" min="1" readonly value="{{$doctor->user['phone']}}" name="phone" class="form-control @error('phone') is-invalid @enderror" required>
                        </div>
                        @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="col-form-group">{{__('Languages')}}<span class="aestric">*</span></label>
                        <select name="language[]" class="select2 @error('language') is-invalid @enderror" multiple required>
                            @foreach ($languages as $hospital)
                            <option value="{{ $hospital->id }}" {{ in_array($hospital->id,json_decode($doctor->language) ?? []) ? 'selected' : '' }}>{{ $hospital->name }}</option>
                            @endforeach
                        </select>
                        @error('language')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
               <!--  </div>

                <div class="row mt-4"> -->
                    <div class="col-lg-6 form-group">
                        <label class="col-form-group">{{__('Date of birth')}}<span class="aestric">*</span></label>
                        <input type="text" value="{{ $doctor->dob }}" class="form-control datePicker @error('dob') is-invalid @enderror" name="dob" required>
                        @error('dob')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="col-form-group">{{__('Gender')}}<span class="aestric">*</span></label>
                        <select name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                            <option value="male" {{ $doctor->gender == 'male' ? 'selected' : '' }}>{{__('Male')}}</option>

                            <option value="female" {{ $doctor->gender == 'female' ? 'selected' : '' }}>{{__('Female')}}</option>

                            <option value="transgender" {{ $doctor->gender == 'transgender' ? 'selected' : '' }}>{{__('Transgender')}}</option>

                            <option value="non-binary" {{ $doctor->gender == 'non-binary' ? 'selected' : '' }}>{{__('Non Binary')}}</option>

                            <option value="prefer-not-to-say" {{ $doctor->gender == 'prefer-not-to-say' ? 'selected' : '' }}>{{__('Prefer Not to say')}}</option>

                            <option value="other" {{ $doctor->gender == 'other' ? 'selected' : '' }}>{{__('other')}}</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-lg-12 form-group">
                        <label class="col-form-group">{{__('Address')}}<span class="aestric">*</span></label>
                        <textarea name="address" rows="10" cols="10" class="form-control @error('desc') is-invalid @enderror" required>{{ $doctor->address }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-lg-4 form-group">
                        <label class="col-form-group">{{__('City')}}<span class="aestric">*</span></label>
                        <input type="text" value="{{ $doctor->city }}" class="form-control  @error('city') is-invalid @enderror" name="city" required>
                        @error('city')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-lg-4 form-group">
                        <label class="col-form-group">{{__('State')}}<span class="aestric">*</span></label>
                        <input type="text" value="{{ $doctor->state }}" class="form-control  @error('state') is-invalid @enderror" name="state" required>
                        @error('state')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-lg-4 form-group">
                        <label class="col-form-group">{{__('Country')}}<span class="aestric">*</span></label>
                        <input type="text" value="{{ $doctor->country }}" class="form-control  @error('country') is-invalid @enderror" name="country" required>
                        @error('country')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-lg-6 form-group">
                        <label class="col-form-group">{{__('Designation')}}<span class="aestric">*</span></label>
                        <input type="text" value="{{ $doctor->designation }}" class="form-control  @error('designation') is-invalid @enderror" name="designation" required>
                        @error('designation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-lg-12 form-group">
                        <label class="col-form-group">{{__('About Me')}}<span class="aestric">*</span></label>
                        <textarea name="desc" rows="10" cols="10" class="form-control @error('desc') is-invalid @enderror" required>{{ $doctor->desc }}</textarea>
                        @error('desc')
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
                <div class="row mt-4">
                    <div class="col-lg-12 form-group">
                        <label class="col-form-group">{{__('Add Education')}}</label>
                        <div class="education-info">
                            @if (json_decode($doctor->education))
                                @foreach (json_decode($doctor->education) as $education)
                                <div class="row form-row education-cont">
                                        <div class="col-12 col-md-10 col-lg-11">
                                            <div class="row form-row">
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>{{__('Degree')}}<span class="aestric">*</span></label>
                                                        <input type="text" value="{{ $education->degree ?? '' }}" required name="degree[]" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>{{__('College/Institute')}}<span class="aestric">*</span></label>
                                                        <input type="text" value="{{ $education->college ?? '' }}" required name="college[]" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>{{__('Year of Completion')}}<span class="aestric">*</span></label>
                                                        <input type="text" maxlength="4" value="{{ $education->year ?? '' }}" pattern="^[0-9]{4}$" required name="year[]" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>{{__('Upload Degree')}}</label>
                                                        <input type='hidden' name="degreeFile[]" value="{{ $education->degreeFile ?? '' }}" accept=".png, .jpg, .jpeg, .pdf" />
                                                        <input type='file' id="degree" name="degree_{{$loop->iteration}}" accept=".png, .jpg, .jpeg, .pdf" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($loop->iteration != 1)
                                            <div class="col-12 col-md-2 col-lg-1">
                                                <label class="d-md-block d-sm-none d-none">&nbsp;</label>
                                                <a href="javascript:void(0);" class="btn btn-danger trash">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        @endif
                                </div>
                                @endforeach
                            @else
                            <div class="row form-row education-cont">
                                <div class="col-12 col-md-10 col-lg-11">
                                    <div class="row form-row">
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Name of Degree')}}<span class="aestric">*</span></label>
                                                <input type="text" required name="degree[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('University')}}<span class="aestric">*</span></label>
                                                <input type="text" required name="college[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Year of Passing')}}<span class="aestric">*</span></label>
                                                <input type="text" maxlength="4" pattern="^[0-9]{4}$" required name="year[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Upload Degree')}}</label>
                                                <input type='file' id="degree" name="degree_1" accept=".png, .jpg, .jpeg, .pdf" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="add-more">
                            <a href="javascript:void(0);" class="add-education"><i class="fa fa-plus-circle"></i>{{__(' Add More')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header text-primary">
                {{__('Licenses')}}
            </div>
            <div class="card-body">
                <div class="row mt-4">
                    <div class="col-lg-12 form-group">
                        <div class="license-info">
                            @if (json_decode($doctor->license))
                                @foreach (json_decode($doctor->license) as $license)
                                <div class="row form-row license-cont">
                                        <div class="col-12 col-md-10 col-lg-11">
                                            <div class="row form-row">
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>{{__('Name')}}</label>
                                                        <input type="text" value="{{ $license->licenseName ?? '' }}" name="licenseName[]" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>{{__('License Number')}}</label>
                                                        <input type="text" value="{{ $license->licenseNumber ?? '' }}" name="licenseNumber[]" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>{{__('Issued By')}}</label>
                                                        <input type="text" value="{{ $license->issuedBy ?? '' }}" name="issuedBy[]" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>{{__('Date of Issue')}}</label>
                                                        <input type="date" value="{{ $license->issueDate ?? '' }}" name="issueDate[]" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>{{__('Date of Expiration')}}</label>
                                                        <input type="date" value="{{ $license->expiryDate ?? '' }}" name="expiryDate[]" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>{{__('Upload License')}}</label>
                                                        <input type='hidden' name="licenseFile[]" value="{{ $license->licenseFile ?? '' }}" accept=".png, .jpg, .jpeg, .pdf" />
                                                        <input type='file' id="license" name="license_{{$loop->iteration}}" accept=".png, .jpg, .jpeg, .pdf" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($loop->iteration != 1)
                                            <div class="col-12 col-md-2 col-lg-1">
                                                <label class="d-md-block d-sm-none d-none">&nbsp;</label>
                                                <a href="javascript:void(0);" class="btn btn-danger trash">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        @endif
                                </div>
                                @endforeach
                            @else
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
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Upload License')}}</label>
                                                <input type='file' id="license" name="license_1" accept=".png, .jpg, .jpeg, .pdf" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="add-more">
                            <a href="javascript:void(0);" class="add-license"><i class="fa fa-plus-circle"></i>{{__(' Add More')}}</a>
                        </div>
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
                            @if (json_decode($doctor->certificate))
                                @foreach (json_decode($doctor->certificate) as $certificate)
                                    <div class="row form-row awards-cont">
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Name')}}</label>
                                                <input type="text" value="{{ $certificate->certificate ?? '' }}" name="certificate[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Issued By')}}</label>
                                                <input type="text" value="{{ $certificate->issuedBy ?? '' }}" name="certificate_issuedBy[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Date of Issue')}}</label>
                                                <input type="date" value="{{ $certificate->issueDate ?? '' }}" name="certificate_issueDate[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Date of Expiration')}}</label>
                                                <input type="date" value="{{ $certificate->expiryDate ?? '' }}" name="certificate_expiryDate[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Upload Certificate')}}</label>
                                                <input type='hidden' name="certificateFile[]" value="{{ $certificate->certificateFile ?? '' }}" accept=".png, .jpg, .jpeg, .pdf" />
                                                <input type='file' id="certificate" name="certificate_{{$loop->iteration}}" accept=".png, .jpg, .jpeg, .pdf" />
                                            </div>
                                        </div>
                                        @if ($loop->iteration != 1)
                                        <div class="col-12 col-md-2">
                                            <label class="d-md-block d-sm-none d-none">&nbsp;</label>
                                            <a href="javascript:void(0);" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a>
                                        </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
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
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label>{{__('Upload Certificate')}}</label>
                                            <input type='file' id="certificate" name="certificate_1" accept=".png, .jpg, .jpeg, .pdf" />
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                            @if (json_decode($doctor->experience_details))
                                @foreach (json_decode($doctor->experience_details) as $experience)
                                    <div class="row form-row experience-cont">
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                            <label class="col-form-group">{{__('Experience (in years)')}}</label>
                                            <input type="number" min="1" name="experience_years[]" value="{{ $experience->experience_years }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Company Name')}}</label>
                                                <input type="text" name="company[]" value="{{ $experience->company ?? '' }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Job Title')}}</label>
                                                <input type="text" value="{{ $experience->job_title ?? '' }}" name="job_title[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Duration')}}</label>
                                                <input type="number" value="{{ $experience->duration ?? '' }}" name="duration[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Location')}}</label>
                                                <input type='text' name="location[]" value="{{ $experience->location ?? '' }}" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Description')}}</label>
                                                <input type='text' name="description[]" value="{{ $experience->description ?? '' }}" class="form-control" />
                                            </div>
                                        </div>
                                        @if ($loop->iteration != 1)
                                        <div class="col-12 col-md-2">
                                            <label class="d-md-block d-sm-none d-none">&nbsp;</label>
                                            <a href="javascript:void(0);" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a>
                                        </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
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
                            @endif
                        </div>
                        <div class="add-more">
                            <a href="javascript:void(0);" class="add-experience"><i class="fa fa-plus-circle"></i>{{__(' Add More')}}</a>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-6 form-group">
                        <label class="col-form-group">{{__('Areas of Expertise')}}<span class="aestric">*</span></label>
                        <select name="treatment_id[]" id="treatment_id" class="select2 @error('treatment_id') is-invalid @enderror" required multiple>
                            @foreach ($treatments as $treatment)
                            <option value="{{ $treatment->id }}" {{ in_array($treatment->id,json_decode($expertises->expertise_id ?? '') ?? []) ? 'selected' : '' }}>{{ $treatment->name }}</option>
                            @endforeach
                        </select>
                        @error('treatment_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="col-form-group">{{__('Therapy Specializations')}}<span class="aestric">*</span></label>
                        <br>
                        <select name="category_id[]" id="category_id" class="select2 form-control @error('category_id') is-invalid @enderror" required multiple="multiple">
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ in_array($category->id,json_decode($specializations->specialisation_id ?? '') ?? []) ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
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
                {{__('Upload Documents')}}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-form-group">{{__('Upload CV')}}<span class="aestric">*</span></label>
                            <br>
                            <div class="avatar-upload avatar-box avatar-box-left">
                                @if($doctor->cv_type != 'pdf')
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url({{ $doctor->CV }});">
                                    </div>
                                </div>
                                @else
                                <iframe src="{{ $doctor->CV }}" frameborder="0"></iframe>
                                @endif
                            </div>
                            <input class="mt-2" type='file' id="cv_image" name="cv_image" accept=".png, .jpg, .jpeg, .pdf" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-form-group">{{__('ID Proof')}}<span class="aestric">*</span></label>
                            <br>
                            <div class="avatar-upload avatar-box avatar-box-left">
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url({{ $doctor->IdDocument }});">
                                    </div>
                                </div>
                            </div>
                            <input class="mt-2" type='file' id="id_proof" name="id_proof" accept=".png, .jpg, .jpeg" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right p-2">
            <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
        </div>
    </form>
</section>

@endsection

