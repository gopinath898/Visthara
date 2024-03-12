@extends('layout.mainlayout_admin',['activePage' => 'pharmacy'])

@section('title',__('Edit pharmacy'))
@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Edit Assesment'),
        'url' => url('Assesment'),
        'urlTitle' => __('Assesment')
    ])

    <div class="section_body">
     <form action="{{ url('pharmacy/'.$pharmacy->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2 col-md-4">
                            <label for="pharmacy_image" class="col-form-label"> {{__('Assesment image')}}</label>
                            <div class="avatar-upload avatar-box avatar-box-left">
                                <div class="avatar-edit">
                                    <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg" />
                                    <label for="image"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url({{ $pharmacy->fullImage }});">
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
                                <input type="text" value="{{ $pharmacy->name }}" name="name" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            
                    </div>
                   
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label">{{__('Description')}}</label>
                        <textarea name="description" class="form-control summernote @error('description') is-invalid @enderror">{{ $pharmacy->description }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">{{__('Low Symptoms Description')}}</label>
                        <textarea name="low" class="form-control  @error('low') is-invalid @enderror">{{ $pharmacy->low }}</textarea>
                        @error('low')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">{{__('Moderate Symptoms Description')}}</label>
                        <textarea name="moderate" class="form-control  @error('moderate') is-invalid @enderror">{{ $pharmacy->moderate }}</textarea>
                        @error('moderate')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">{{__('High Symptoms Description')}}</label>
                        <textarea name="high" class="form-control  @error('high') is-invalid @enderror">{{ $pharmacy->high }}</textarea>
                        @error('high')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label class="col-form-label">{{__('Low Recommended Description')}}</label>
                        <textarea name="rec_low" class="form-control  @error('rec_low') is-invalid @enderror">{{ $pharmacy->rec_low }}</textarea>
                        @error('rec_low')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">{{__('Moderate Recommended Description')}}</label>
                        <textarea name="rec_moderate" class="form-control  @error('rec_moderate') is-invalid @enderror">{{ $pharmacy->rec_moderate }}</textarea>
                        @error('rec_moderate')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">{{__('High Recommended Description')}}</label>
                        <textarea name="rec_high" class="form-control  @error('rec_high') is-invalid @enderror">{{ $pharmacy->rec_high }}</textarea>
                        @error('rec_high')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                
                    
            </div>
            <div class="card mt-5">
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-form-label">{{__('Allow Multiple Question ?')}}</label>
                        <label class="cursor-pointer ml-2">
                            <input type="checkbox" id="is_shipping" class="custom-switch-input" name="is_shipping" {{ $pharmacy->is_shipping == 1 ? 'checked' : "" }}>
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>
                    <div class="row mt-4 deliveryChargeDiv {{ $pharmacy->is_shipping != 1 ? 'hide' : '' }}">
                        <div class="col-lg-12">
                            <table class="table mt-2 delivery_charge_table">
                                <thead class="font-bold">{{__("Questions & Score")}}</thead>
                                <tbody>
                                    <tr>
                                        <td>{{__('Question')}}</td>
                                        <td>{{__('Answers(Camma Saperated)')}}<br> Ex ; Yes,No,None</td>
                                        <td>{{__('Score(Camma Saperated)')}} <br>Ex:10,12,14,24</td>
                                        <td></td>
                                    </tr>
                                    @php
                                        $delivery_charge = json_decode($pharmacy->delivery_charges);
                                    @endphp
                                    @if ($delivery_charge != null)
                                        @foreach ($delivery_charge as $delivery_charge)
                                            <tr>
                                                <td><input type="text"  name="min_value[]" value="{{ $delivery_charge->min_value }}" class="form-control min_value"></td>
                                                <td><textarea type="text" value=""  name="max_value[]"  class="form-control max_value">{{ $delivery_charge->max_value }}</textarea></td>
                                                <td><input type="text" name="charges[]" value="{{ $delivery_charge->charges }}" class="form-control charges"></td>
                                                @if ($loop->iteration == 1)
                                                    <td><button type="button" class="btn btn-primary" onclick="addCharge()"><i class="fas fa-plus"></i></button></td>
                                                @else
                                                    <td><button type="button" class="btn btn-danger removebtn"><i class="fas fa-times"></i></button></td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td><input type="text"  name="min_value[]" class="form-control min_value"></td>
                                            <td><textarea type="text" value="10" name="max_value[]" class="form-control max_value"></textarea></td>
                                            <td ><input type="text"   name="charges[]" class="form-control charges"></td>
                                            <td><button type="button" class="btn btn-primary" onclick="addCharge()"><i class="fas fa-plus"></i></button></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
                <div class="text-right m-4">
                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script src="{{ url('assets_admin/js/hospital_map.js') }}"></script>
    
@endsection