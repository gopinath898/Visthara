@extends('layout.mainlayout_admin',['activePage' => 'appointment'])

@section('title',__('Appointment'))
<style>
#button-16 .knobs:before
{
    content: 'YES';
    position: absolute;
    top: 4px;
    left: 4px;
    width: 20px;
    height: 10px;
    color: #fff;
    font-size: 10px;
    font-weight: bold;
    text-align: center;
    line-height: 1;
    padding: 9px 4px;
    background-color: #03A9F4;
    border-radius: 2px;
    transition: 0.3s ease all, left 0.3s cubic-bezier(0.18, 0.89, 0.35, 1.15);
}

#button-16 .checkbox:active + .knobs:before
{
    width: 46px;
}

#button-16 .checkbox:checked:active + .knobs:before
{
    margin-left: -26px;
}

#button-16 .checkbox:checked + .knobs:before
{
    content: 'NO';
    left: 42px;
    background-color: #F44336;
}

#button-16 .checkbox:checked ~ .layer
{
    background-color: #fcebeb;
}
</style>
@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Appointment'),
    ])
    <div class="section-body">
        @if (session('status'))
            @include('superAdmin.auth.status',['status' => session('status')])
        @endif
        <div class="justify-content-center border-bottom bg-white">
            <ul class="appointment-ul"> 

                <li class="text-center">
                    <a href="javascript:void(0)" onclick="seeData('.alldata')" class="h-100 w-100">All Sessions</a>
                </li>

                <li class="text-center">
                    <a href="javascript:void(0)" onclick="seeData('.UpcomingAppointments','.CompletedAppointments')" class="h-100 w-100">Upcoming Sessions</a>
                </li>
                <li class="text-center">
                    <a href="javascript:void(0)" class="h-100 w-100" onclick="seeData('.CompletedAppointments', '.UpcomingAppointments')">{{ __('Completed Sessions') }}</a>
                </li>
            </ul>
        </div>
        <div class="card-header w-100 text-right d-flex justify-content-between">
            <!-- <input type="button" value="{{__('Delete Selected')}}" onclick="deleteAll('appointment_all_delete')" class="btn btn-primary"> -->
            @include('superAdmin.auth.exportButtons')
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="w-100 display table datatable">
                    <thead>
                        <tr>
                            <th>
                                <input name="select_all" value="1" id="master" type="checkbox" />
                                <label for="master"></label>
                            </th>
                            <th> # </th>
                            <th>{{__('appointment id')}}</th>
                            <th>Client Name</th>
                            
                            <th>{{__('status')}}</th>
                            @if (auth()->user()->hasRole('Therapist'))
                                <th>{{__('change status')}}</th>
                            @endif
                            <th>{{__('view appointment')}}</th>  
                            @if (!auth()->user()->hasRole('Therapist'))
                                <th>{{__('Therapist name')}}</th>
                            @endif

                            <th>{{__('date')}}</th>
                            @if (auth()->user()->hasRole('Therapist'))
                                <th>{{__('Attachments')}}</th>
                                <th>{{__('Guardian Name')}}</th>
                            @endif


                            @if (auth()->user()->hasRole('super admin'))  
                                    <th>{{__('Action')}}</th>
                            @endif  

                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($sessions as $session)


                            @php 
                            if($session->session_status == 'pending' || $session->session_status == 'PENDING' || $session->session_status == 'approve' || $session->session_status == 'APPROVE' || $session->session_status == 'booked'){
                                $seeDataId = 'UpcomingAppointments';
                            }
                            else{
                                $seeDataId = 'CompletedAppointments';
                            }
                            if($session->zoomSessions){
                                $zoomobj = json_decode($session->zoomSessions,true);
                                $zoomurl = $zoomobj['meta']['start_url'];
                            }else{
                                $zoomurl='';
                            } 
                                        
                            @endphp
                            <tr class="{{$seeDataId}} alldata">
                                <td>
                                    <input type="checkbox" name="id[]" value="{{$session->id}}" id="{{$session->id}}" data-id="{{ $session->id }}" class="sub_chk">
                                    <label for="{{$session->id}}"></label>
                                </td>


                                <td>{{ $session->id }}</td>
                                <td>{{ $session->appointment_id }}</td>
                                <td>
                                    @if(isset($session->user->name))
                                    {{ $session->user->name }}
                                    @endif
                                </td>                                
                                <td>
                                    @if($session->session_status == 'pending')
                                        <span class="badge badge-pill bg-warning-light">{{__('Pending')}}</span>
                                    @endif
                                   
                                    @if($session->session_status == 'booked' || $session->session_status == 'BOOKED')
                                        <span class="badge badge-pill bg-warning-light">{{__('Booked')}}</span>
                                    @endif
                                    @if($session->session_status == 'approve' || $session->session_status == 'APPROVE')
                                        <span class="badge badge-pill bg-success-light">{{__('Approve')}}</span>
                                    @endif
                                    @if($session->session_status == 'cancel' || $session->session_status == 'CANCEL')
                                        <span class="badge badge-pill bg-danger-light">{{__('Cancelled')}}</span>
                                    @endif
                                    @if($session->session_status == 'complete' || $session->session_status == 'COMPLETE')
                                        <span class="badge badge-pill bg-default-light">{{__('Complete')}}</span>
                            

                                    @endif
                                </td>
                                @if (auth()->user()->hasRole('Therapist'))
                                <td class="d-flex w-100">
                                    @if ($session->session_status == 'approve' ||  $session->session_status == 'complete')
                                        <a href="{{ url('completeAppointment/'.$session->appointment->id.'/'.$session->id) }}" class="btn btn-sm bg-info-light {{ $session->session_status == 'complete' ? 'disabled' : '' }}">
                                            <i class="fas fa-check"></i> {{__('Complete')}}
                                        </a>
                                    @elseif($session->session_status == 'pending' || $session->session_status == 'cancel' || $session->session_status == 'booked')
                                        <a href="{{ url('acceptAppointment/'.$session->appointment->id.'/'.$session->id) }}" class="btn btn-sm bg-success-light {{ $session->session_status != 'booked' ? 'disabled-none' : '' }}">
                                            <i class="fas fa-check"></i> {{__('Accept')}}
                                        </a>
                                @if (auth()->user()->hasRole('super admin'))
                                        <a href="{{ url('cancelAppointment/'.$session->appointment->id.'/'.$session->id) }}" class="btn btn-sm bg-danger-light ml-2 {{ $session->session_status != 'booked' ? 'disabled' : '' }}">
                                            <i class="fas fa-times"></i>{{__(' Cancel')}}
                                        </a>
                                    @endif
                                 @endif
                                </td>
                                @endif
                                <td>
                                    @if (auth()->user()->hasRole('Therapist'))
                                    <a href="{{$zoomurl}}" class="btn-primary btn" style="display: block ruby;"><span><i class="fa fa-video"></i>{{__(' Call')}}</span>             
                                    </a>
                                    <br>
                                    <a href="{{url('/startchat/?to_user_id='.$session->doctor->user_id.'&user_id='.$session->appointment->user_id)}}" class="btn-primary btn" style="display: block ruby;"><span><i class="fa fa-list"></i>{{__(' Chat')}}</span>             
                                    </a>
                                    
                                    <br>
                                    @endif

                                    <a href="#edit_specialities_details" onclick="show_appointment({{$session->appointment->id}}, {{$session->id}})" data-toggle="modal" class="text-info">
                                        {{__(' View')}}
                                    </a>
                                </td>
                               
                                @if (!auth()->user()->hasRole('Therapist'))
                                 <td>
                                    @if(isset($session->doctor->name))
                                    {{ $session->doctor->name }}
                                    @endif
                                  </td>
                                @endif
                              

                                <td>{{ $session->session_date }}<span class="d-block text-info">{{ $session->session_timeslot }}</span></td>

                                
                                @if (auth()->user()->hasRole('Therapist'))

                                    <td>
                                        <a href="#add_attachments" onclick="appointId({{ $session->appointment->id }})" class="btn-primary btn" data-toggle="modal" style="display: block ruby;">
                                            <span>{{__('Upload')}}</span>             
                                        </a>
                                        <a href="#view_attachments" onclick="view_attachments({{ $session->appointment->id }})" data-toggle="modal" class="text-info">
                                            {{__(' View')}}
                                        </a>
                                    </td>

                                    <td>
                                        {{ $session->appointment->guardian_name ?? 'NA' }}    
                                    </td>
                                @endif


                                @if (auth()->user()->hasRole('super admin'))  
                                    <td> <a class="btn btn-primary" href="{{url('/editAppointment/'.$session->id)}}">
                                            {{__(' Edit')}}
                                        </a></td>
                                @endif 

                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
                    <tr>
                        <td>{{__('Therapist name')}}</td>
                        <td class="doctor_name"></td>
                    </tr>
                    <tr>
                        <td>{{__('Client name')}}</td>
                        <td class="patient_name"></td>
                    </tr>
                    <tr>
                        <td>{{__('Client age')}}</td>
                        <td class="patient_age"></td>
                    </tr>
                    <tr>
                        <td>{{__('date')}}</td>
                        <td class="date"></td>
                    </tr>
                    <tr>
                        <td>{{__('time')}}</td>
                        <td class="time"></td>
                    </tr>

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

<div class="modal fade" id="view_attachments" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__("Attachments")}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table attachments">
                </table>
                <span class="attachments-error"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_attachments" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__("Attachments")}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="attachmentForm">
                    @csrf
                    <input type="hidden" name="appointment_id" value="">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-form-group">{{__('Upload file')}}</label>
                            <br>
                            <div class='attachment-info'>
                                <input class="mt-2" type='file' id="attachment" name="attachment[]" accept=".png, .jpg, .jpeg, .pdf, .doc" />
                            </div>
                        </div>
                        <div class="add-more mt-2">
                            <a href="javascript:void(0);" class="add-attachment"><i class="fa fa-plus-circle"></i>{{__(' Add More')}}</a>
                        </div>
                        <span class="invalid-div text-danger"><span class="attachment"></span></span>
                    </div>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="button" onclick="uploadDocument()" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection