@extends('layout.mainlayout_admin',['activePage' => 'enquiries'])

@section('title',__('Enquiries'))

@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Enquiries'),
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
                            <th>Name</th>
                            <th>Email Id</th>
                            <th>Phone No.</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Raised At</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @if(isset($enquiries))
                            @foreach($enquiries as $enquiry)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $enquiry->name }}</td>
                                <td>{{ $enquiry->email }}</td>
                                <td>{{ $enquiry->phone }}</td>
                                <td>{{ $enquiry->subject }}</td>
                                <td>{{ $enquiry->message }}</td>
                                <td>{{ $enquiry->created_at }}</td>
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
