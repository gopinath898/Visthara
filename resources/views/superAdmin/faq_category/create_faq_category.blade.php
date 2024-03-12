@extends('layout.mainlayout_admin',['activePage' => 'radiology_category'])

@section('title',__('FAQ Category'))

@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Add FAQ Category'),
        'url' => url('faq_category'),
        'urlTitle' => __('FAQ'),
    ])

    <div class="section_body">
        <div class="card">
            <form action="{{ url('faq_category') }}" method="post" enctype="multipart/form-data" onsubmit="return encodeField();">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-form-label">{{__('FAQ Category Title Name')}}</label>
                        <input type="text" required value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="text-right mt-4">
                        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection