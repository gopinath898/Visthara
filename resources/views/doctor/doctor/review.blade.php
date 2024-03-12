@extends('layout.mainlayout_admin',['activePage' => 'review'])

@section('title',__('Therapist Review'))

@section('content')
<section class="section">
        @include('layout.breadcrumb',[
            'title' => __('Review'),
        ])

        @if (session('status'))
            @include('superAdmin.auth.status',[
                'status' => session('status')])
            @endif
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table table-hover table-center mb-0 text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('Appointment Id')}}</th>
                                <th>{{__('User name')}}</th>
                                <th>{{__('Review')}}</th>
                                <th>{{__('Rate')}}</th>

                                @if(auth()->user()->hasRole('super admin'))
                                <th>Status</th>
                                <th>Action</th>

                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $review->appointment['appointment_id'] ?? '' }}</td>
                                <td>{{ $review->user['name'] }}</td>
                                <td>{{ $review->review }}</td>
                                <td>
                                    @for ($i = 1; $i < 6; $i++)
                                        @if ($review->rate >= $i)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </td>

                                @if(auth()->user()->hasRole('super admin'))

                                <td>{{ $review->status != 'approved' ? 'Pending' : 'Approved' }}</td>
                                <td>
                                    <a href="{{ url('doctor_review/delete/?id='.$review->id) }}" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> {{__('Delete')}}
                                    </a>
                                    @if ($review->status != 'approved')
                                    <a href="{{ url('doctor_review/update/?id='.$review->id) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i> {{__('Approve')}}
                                    </a>
                                    @endif
                                </td>

                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</section>
@endsection
