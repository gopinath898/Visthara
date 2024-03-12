@extends('layout.mainlayout_admin',['activePage' => 'category'])

@section('title',__('Edit Category'))
@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Edit Category'),
        'url' => url('category'),
        'urlTitle' => __('Category'),
    ])
    @if (session('status'))
    @include('superAdmin.auth.status',[
        'status' => session('status')])
    @endif
    <div class="section_body">
        <div class="card">
            <form action="{{ url('sessionupdate/'.$session->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        
                   
                         <div class="col-md-12">    

                            <div class="form-group">
                                <label class="col-form-label">{{__('Therapist')}}</label>
                                <div class="col-md-12">    
                                <select name="doctor_id" id="doctor_id" class="select2" style="width: 100%">
                                    @foreach ($therapists as $therapist)
                                        <option value="{{ $therapist->id }}" {{ $session->doctor_id == $therapist->id ? 'selected' : '' }}>{{ $therapist->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                           
                        </div>
                   
                        <div class="col-md-12">
                        <div class="form-group">
                                <label class="col-form-label">{{__('Date')}}</label>
                        <input type="date" id="dateslot" min="{{ Carbon\Carbon::now(env('timezone'))->format('Y-m-d') }}" class="form-control" name="date" style="width: 40%">
                           <div class="mt-2 slotes d-flex timeSlotRow">
                           </div>
                           </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
