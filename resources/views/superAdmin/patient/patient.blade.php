@extends('layout.mainlayout_admin',['activePage' => 'patients'])

@section('title',__('All Client'))

@section('content')

<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Client'),
    ])
    <div class="section_body">
        @if (session('status'))
        @include('superAdmin.auth.status',[
            'status' => session('status')])
        @endif
        <div class="card">
            <div class="card-header w-100 text-right d-flex justify-content-between">
                @include('superAdmin.auth.exportButtons')
                @can('patient_add')
                    <a href="{{ url('patient/create') }}">{{ __("Add New") }}</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table table-hover table-center mb-0 text-center">
                        <thead>
                            <tr>
                                <th>
                                    <input name="select_all" value="1" id="master" type="checkbox" />
                                    <label for="master"></label>
                                </th>
                                <th>#</th>
                                <th>{{__('User Name')}}</th>
                                @if(auth()->user()->hasRole('super admin'))
                                        <th>
                                            Eemail
                                        </th>
                                        <th>
                                            Phone
                                        </th>
                                        <th>
                                            Gender
                                        </th>
                                        <th>
                                            DOB
                                        </th>
                                    @endif
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id[]" value="{{$user->id}}" id="{{$user->id}}" data-id="{{ $user->id }}" class="sub_chk">
                                        <label for="{{$user->id}}"></label>
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <p class="table-avatar">
                                            <a href="{{ url('patient/'.$user->id) }}" class="avatar avatar-sm mr-2">
                                                <img class="avatar-img rounded-circle" src="{{ $user->fullImage }}" alt="patient Image"></a>
                                            <a href="{{ url('patient/'.$user->id) }}">{{ $user->name }}</a>
                                        </p>
                                    </td>

                                    @if(auth()->user()->hasRole('super admin'))
                                        <td>
                                            {{ $user->email }}
                                        </td>
                                        <td>
                                            {{ $user->phone }}
                                        </td>

                                        <td>
                                            {{ $user->gender }}
                                        </td>

                                        <td>
                                            {{ $user->dob }}
                                        </td>
                                    
                                    <td>
                                        <a class="btn-primary btn btn-sm" href="{{ url('patient/buy-subscription/'.$user->id) }}"><i class="far fa-calendar-check"> Booking</i>
                                        </a>

                                        <a class="btn btn-success" href="{{url('patient/'.$user->id.'/edit')}}">
                                                <i class="far fa-edit"> Edit </i>
                                            </a>
                                    </td>

                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <input type="button" value="delete selected" onclick="deleteAll('patient_all_delete')" class="btn btn-primary">
            </div>
        </div>
    </div>
</section>

@endsection
