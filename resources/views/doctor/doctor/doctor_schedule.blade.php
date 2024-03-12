@extends('layout.mainlayout_admin',['activePage' => 'schedule'])

@section('title',__('Schedule'))
@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Therapist schedule'),
    ])

        <input type="hidden" name="start_time" value="{{ $doctor->start_time }}">
        <input type="hidden" name="end_time" value="{{ $doctor->end_time }}">
        <input type="hidden" name="timeslot" value="{{ $doctor->timeslot == 'other' ? $doctor->custom_timeslot : $doctor->timeslot }}">
        <div class="card">
            <div class="card-header">
                {{__('Schedule Timings')}}
                <div id="slot_sunday" class="tab-pane fade show active" style="margin-left:auto;">

                    <input type="hidden" name="working_id" value="{{$doctor->firstHours->id ?? ''}}">
                    <h6 class="card-title d-flex float-right justify-content-between">
                        <a class="edit-link float-right mt-2" data-toggle="modal" href="#create_time_slot">
                            <i class="fa fa-edit mr-1"></i> {{__('Create Slot')}}
                        </a>
                    </h6>

                </div>
            </div>
            <div class="card-body">
                <div class="profile-box">
                    <div class="card schedule-widget mb-0">
                        <div class="schedule-header">
                            <div class="schedule-nav">

                             <div class="row"> 
                                <ul class="nav nav-tabs nav-justified" style="width: 100%">
                               
                                    @if($doctor->workingHours)
                                    @foreach ($doctor->workingHours as $working)
                                   
                                        <li class="col-md-2 nav-item p-1">
                                            <a class="nav-link {{ $loop->iteration == 1 ? 'active' : '' }}" onclick="display_timeslot('{{ $working->booking_date }}',{{$working->doctor_id}})" data-toggle="tab" href="#slot_sunday">{{ $working->booking_date }}</a>
                                        </li>
                                 
                                    @endforeach
                                    @endif
                               
                                </ul>
                                 </div>
                            </div>
                        </div>

                        <div class="tab-content">
                            <div id="slot_sunday" class="tab-pane fade show active">
                                <input type="hidden" name="working_id" value="{{$doctor->firstHours->id ?? ''}}">
                                @if($doctor->firstHours)
                                <h6 class="card-title d-flex float-right justify-content-between">
                                    <a class="edit-link btn btn-danger float-right mt-5" data-toggle="modal" onclick="edit_timeslot()" href="#edit_time_slot">
                                        <i class="fa fa-edit mr-1"></i> {{__('Edit Slot')}}
                                    </a>
                                </h6>
                                @endif
                                <div class="doc-times">
                                    @if(json_decode($doctor->firstHours->period_list ?? ''))
                                    @foreach (json_decode($doctor->firstHours->period_list) as $list)
                                        <div class="badge badge-primary ml-2 mt-5">
                                        {{$list->start_time}} - {{$list->end_time}}
                                        </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<div class="modal fade" id="edit_time_slot" tabindex="-1" role="dialog" aria-labelledby="edit_time_slot" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="" method="post" class="working_form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{__('Edit Time Slot')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="working_id" value="">
                    <div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">{{__('Day Status')}}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="cursor-pointer">
                                    <input type="checkbox" id="status_1" class="custom-switch-input" name="status" checked>
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="hours-info mt-3">
                        <div class="row form-row hours-cont display_timing">
                            <div class="col-12 col-md-10">
                            </div>
                        </div>
                    </div>
                    <div class="add-more mb-3">
                        <a href="javascript:void(0);" class="add-hours"><i class="fa fa-plus-circle"></i> Add More</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="create_time_slot" tabindex="-1" role="dialog" aria-labelledby="create_time_slot" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="" method="post" class="create_working_hours">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{__('Create Time Slot')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="working_doctor_id" value={{ $doctor->id }}>
                    @if(auth()->user()->hasRole('super admin'))
                    <input type="hidden" name="working_doctor_user_id" value={{ request()->doctor_id ?? ''}}>
                    @endif
                    <input type="hidden" id="status_1" class="custom-switch-input" name="status" checked>
                    <div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">{{__('Date')}}</label>
                            </div>
                            <div class="col-md-6">
                                <input type="date" required name="booking_date" id="booking_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="create-hours-info mt-3">
                        <div class="row form-row hours-cont create_timing">
                            <div class="col-12 col-md-10">
                            </div>
                        </div>
                    </div>
                    <div class="add-more mb-3">
                        <a href="javascript:void(0);" class="create-hours"><i class="fa fa-plus-circle"></i> Add More</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

