@extends('layout.mainlayout_admin',['activePage' => 'radiology_category'])

@section('title',__('Radiology Category'))

@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Add FAQ '),
        'url' => url('faq_data'),
        'urlTitle' => __('FAQ'),
    ])

    <div class="section_body">
        <div class="card">
            <form action="{{ url('faq_data') }}" method="post" enctype="multipart/form-data" onsubmit="return encodeField();">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-form-label">{{__('FAQ Title Name')}}</label>
                        <input type="text" required value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">{{__('FAQ Category')}}</label>
                        <select name="category_id" id="category_id" required class="form-control @error('name') is-invalid @enderror">
                            <option value="">Select Category</option>
                            @foreach($faq_categories as $faq_category)
                            <option value="{{$faq_category->id}}">{{ $faq_category->name }}</option>
                            @endforeach
                        </select>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">{{__('FAQ description')}}</label>
                        <textarea required value="{{ old('description') }}" name="description" id="description" class="form-control summernote @error('description') is-invalid @enderror"></textarea> 
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