@extends('layout.mainlayout_admin',['activePage' => 'doctor'])

@section('title','Bank Details')

@section('content')
<section class="section">

    @include('layout.breadcrumb',[
        'title' => __('Bank Details'),
    ])

    <form action="{{ url('update_doctor_bank') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header text-primary">
                {{__('Bank information')}}
            </div>
            <div class="card-body">
                <div class="row mt-4">
                    <div class="col-lg-10 col-md-8">
                        <div class="form-group">
                            <label class="col-form-label">{{__('Account Holder Name')}}</label>
                            <input type="text" value="{{ $doctor->user['holder_name'] }}" name="holder_name" class="form-control @error('holder_name') is-invalid @enderror">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
    
                        <div class="form-group">
                            <label class="col-form-label">{{__('Account Number')}}</label>
                            <input type="text"  value="{{ $doctor->user['account_number'] }}" name="account_number" class="form-control @error('account_number') is-invalid @enderror">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label class="col-form-label">{{__('IFSC CODE')}}</label>
                            <input type="text" value="{{ $doctor->user['ifsc_code'] }}" name="ifsc_code" class="form-control @error('ifsc_code') is-invalid @enderror">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label class="col-form-label">{{__('Bank Name')}}</label>
                            <input type="text" value="{{ $doctor->user['bank_name'] }}" name="bank_name" class="form-control @error('bank_name') is-invalid @enderror">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label class="col-form-label">{{__('Branch Detials')}}</label>
                            <input type="text" value="{{ $doctor->user['branch'] }}" name="branch" class="form-control @error('branch') is-invalid @enderror">
                            @error('name')
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
</section>
@endsection