@extends('layout.mainlayout_admin',['activePage' => 'appointment'])

@section('title',__('Sessions'))

@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Sessions'),
    ])
    <div class="section-body">
        @if (session('status'))
            @include('superAdmin.auth.status',['status' => session('status')])
        @endif
        <div class="card-body">
            <div class="table-responsive">
                <table class="w-100 display table datatable">
                    <thead class="text-center">
                        <tr>
                            <th> # </th>
                            <th>Appointment Id</th>
                            <th>Patient Name</th>
                            <th>Status</th>
                            <th>Updated At</th>
                            @if (auth()->user()->hasRole('Therapist'))
                            <th>Action</th>
                            @endif
                            <th>Appointment at</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @if(isset($appointmentSessions))
                            @foreach($appointmentSessions as $session)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $session->appointment_id }}</td>
                                <td>{{ $session->patient_name }}</td>
                                <td>{{ $session->session_status }}</td>
                                <td>{{ $session->updated_at }}</td>

                                @if (auth()->user()->hasRole('Therapist'))
                                <td>
                                    @if($session->session_status == "pending")
                                    <a href="{{ url('completeSession/'.$session->id) }}" class="btn btn-sm bg-success-light">
                                        <i class="fas fa-check"></i> {{__('Complete')}}
                                    </a>
                                    @elseif($session->session_status == "booked")
                                    <a href="{{$session->zoomurl}}" class="btn btn-sm bg-primary-light" >
                                        <i class="fa fa-video"></i>{{__('Call')}}
                                    </a>
                                    @else
                                    <a href="#" class="btn btn-sm bg-danger-light">
                                        {{__('Session Done')}}
                                    </a>
                                    @endif
                                </td>
                                @endif
                                <td>
                                    @if($session->session_status == "booked")
                                    {{ $session->session_date }} {{ $session->session_timeslot }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection
