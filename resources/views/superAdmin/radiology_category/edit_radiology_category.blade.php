@extends('layout.mainlayout_admin',['activePage' => 'radiology_category'])

@section('title',__('Radiology Category'))

@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Edit FAQ'),
        'url' => url('faq_data'),
        'urlTitle' => __('FAQ'),
    ])

    <div class="section_body">
        <div class="card">
            <form action="{{ url('faq_data/'.$radiology_category->id) }}" method="post" enctype="multipart/form-data" onsubmit="return encodeField();">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-form-label">{{__('FAQ Title')}}</label>
                        <input type="text" required value="{{ old('name',$radiology_category->name) }}" name="name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">{{__('FAQ Category')}}</label>
                        <select name="category_id" id="category_id" required class="form-control @error('name') is-invalid @enderror">
                            @foreach($faq_categories as $faq_category)
                            <option value="{{$faq_category->id}}" {{ $faq_category->id == $radiology_category->category_id ? 'selected' : '' }}>{{ $faq_category->name }}</option>
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
                        <textarea required name="description" id="description" class="form-control summernote @error('description') is-invalid @enderror">{{ old('description',$radiology_category->description) }}</textarea> 
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label class="col-form-label">{{__('FAQ Sort No')}}</label>
                        <input type="number" required value="{{ old('sort',$radiology_category->sort) }}" name="sort" class="form-control @error('sort') is-invalid @enderror">
                        @error('sort')
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