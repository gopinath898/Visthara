@extends('layout.mainlayout',['active_page' => 'doctors'])

@section('title',__('Therapists'))

@section('content')
    <div class="site-body">
        <div class="full-content">
            <div class="dispDoctor">
                @include('website.display_doctor',['doctor' => $doctors])
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ App\Models\Setting::first()->map_key }}&sensor=false&libraries=places"></script>
    <script src="{{ url('assets/js/doctor_list.js') }}"></script>
@endsection