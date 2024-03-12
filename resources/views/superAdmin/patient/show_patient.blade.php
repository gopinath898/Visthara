@extends('layout.mainlayout_admin',['activePage' => $activePage])

@section('title',__('Show Client Appointment'))
@section('content')

<section class="section">

    @if($user != null)
    @include('layout.breadcrumb',[
        'title' => $user->name . __(' Profile'),
        'url' => url('patient'),
        'urlTitle' => __('Client')
    ])

    @endif
    <div class="section_body">
        <div class="card">
            <div class="card">
                <div class="card-header">
                    @include('superAdmin.auth.exportButtons')
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="w-100 display table datatable">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th>{{__('appointment id')}}
                                    <th>{{__('Client name')}}</th>
                                    <th>{{__('Package name')}}</th>
                                    <th>{{__('Payment status')}}</th>
                                    <th>{{__('Transcation ID')}}</th>
                                    <th>Total Amount</th>
                                    <th>Created At</th>
                                    <th>{{__('Action')}}</th>
                                    @if (auth()->user()->hasRole('Therapist'))
                                        <th>{{__('Add prescription')}}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointments as $appointment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $appointment->appointment_id }}</td>
                                        <!-- <td>
                                            @if ($appointment->report_image != null)
                                                @foreach ($appointment->report_image as $item)
                                                    <a href="{{ $item }}" data-fancybox="gallery2">
                                                        <img src="{{ $item }}" width="50px" height="50px" alt="Feature Image">
                                                    </a>
                                                @endforeach
                                            @else
                                                {{__('Image Not available')}}
                                            @endif
                                        </td> -->
                                       
                                        <td>{{ $appointment->user['name'] ?? '' }}</td>

                                        <td>{{ $appointment->name }}</td>
                                        
                                        <!-- <td>
                                            @if($appointment->appointment_status == 'pending' || $appointment->appointment_status == 'PENDING')
                                                <span class="badge badge-pill bg-warning-light">{{__('Pending')}}</span>
                                            @endif
                                            @if($appointment->appointment_status == 'approve' || $appointment->appointment_status == 'APPROVE')
                                                <span class="badge badge-pill bg-success-light">{{__('Approve')}}</span>
                                            @endif
                                            @if($appointment->appointment_status == 'cancel' || $appointment->appointment_status == 'CANCEL')
                                                <span class="badge badge-pill bg-danger-light">{{__('Cancelled')}}</span>
                                            @endif
                                            @if($appointment->appointment_status == 'complete' || $appointment->appointment_status == 'COMPLETE')
                                                <span class="badge badge-pill bg-default-light">{{__('Complete')}}</span>
                                            @endif
                                        </td> -->
                                        <td>
                                        @if($appointment->payment_status ==1)

                                            Paid

                                        @else
                                            Pending

                                        @endif

                                        </td>

                                        <td>{{$appointment->payment_id}}</td>

                                        <td>{{$appointment->amount}}</td>

                                         <td>{{$appointment->created_at}}</td>
                                        <td>
                                            <!-- <a href="#edit_specialities_details" onclick="show_appointment({{$appointment->id}})" data-toggle="modal" class="btn btn-sm btn-primary">
                                                {{__(' View')}}
                                            </a> -->

                                             <a href="{{ url('download-invoice-user/'.Str::slug($appointment->id)) }}" class="btn rounded-pill"> Invoice</a>


                                              <a href="#edit_specialities_details" onclick="show_appointment({{$appointment->appid}})" data-toggle="modal" class="btn text-info">
                                        {{__(' View')}}
                                            </a>

                                        </td>


                                        @if (auth()->user()->hasRole('Therapist'))
                                        <td>
                                            <a href="{{ url('prescription/'.$appointment->id) }}"  class="btn btn-sm bg-success-light">
                                                <i class="far fa-plus"></i>{{__(' App prescription')}}
                                            </a>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="edit_specialities_details" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__("Appointment")}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <td>{{__('Appointment Id')}}</td>
                        <td class="appointment_id"></td>
                    </tr>
                   <!--  <tr>
                        <td>{{__('Therapist name')}}</td>
                        <td class="doctor_name"></td>
                    </tr> -->
                    <tr>
                        <td>{{__('Client name')}}</td>
                        <td class="patient_name"></td>
                    </tr>
                    <tr>
                        <td>{{__('Client age')}}</td>
                        <td class="patient_age"></td>
                    </tr>
                   <!--  <tr>
                        <td>{{__('date')}}</td>
                        <td class="date"></td>
                    </tr>
                    <tr>
                        <td>{{__('time')}}</td>
                        <td class="time"></td>
                    </tr> -->

                     <tr>
                        <td>{{__('Mental health conditions that you have been diagnosed with')}}</td>
                        <td class="illness"></td>
                    </tr>
                     <tr>
                        <td>{{__('note')}}</td>
                        <td class="note"></td>
                    </tr>

                    <tr>
                        <td>{{__('guardian_name')}}</td>
                        <td class="guardian_name"></td>
                    </tr>

                    <tr>
                        <td>{{__('guardian_phone')}}</td>
                        <td class="guardian_phone"></td>
                    </tr>

                    <tr>
                        <td>{{__('illness_exists')}}</td>
                        <td class="illness_exists"></td>
                    </tr>

                    <tr>
                        <td>{{__('illness_information_taken')}}</td>
                        <td class="illness_information_taken"></td>
                    </tr>

        

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade hide" id="edit_specialities_details" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__("Appointment")}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <td>{{__('appointment Id')}}</td>
                        <td class="appointment_id"></td>
                    </tr>
                    <tr>
                        <td>{{__('Therapist name')}}</td>
                        <td class="doctor_name"></td>
                    </tr>
                    <tr>
                        <td>{{__('Client name')}}</td>
                        <td class="patient_name"></td>
                    </tr>
                    <tr>
                        <td>{{__('Client address')}}</td>
                        <td class="patient_address"></td>
                    </tr>
                    <tr>
                        <td>{{__('Client age')}}</td>
                        <td class="patient_age"></td>
                    </tr>
                    <!-- <tr>
                        <td>{{__('amount')}}</td>
                        <td class="amount"></td>
                    </tr> -->
                    <tr>
                        <td>{{__('date')}}</td>
                        <td class="date"></td>
                    </tr>
                    <tr>
                        <td>{{__('time')}}</td>
                        <td class="time"></td>
                    </tr>
                    <tr>
                        <td>{{__('payment status')}}</td>
                        <td class="payment_status"></td>
                    </tr>
                    <tr>
                        <td>{{__('payment type')}}</td>
                        <td class="payment_type"></td>
                    </tr>
                    <tr>
                        <td>{{__('illness information')}}</td>
                        <td class="illness_info"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
            </div>
        </div>
    </div>
</div>

@endsection
