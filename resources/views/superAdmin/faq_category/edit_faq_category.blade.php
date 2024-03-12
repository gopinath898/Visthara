@extends('layout.mainlayout_admin',['activePage' => 'radiology_category'])

@section('title',__('Radiology Category'))

@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('Edit FAQ Category'),
        'url' => url('faq_category'),
        'urlTitle' => __('FAQ'),
    ])

    <div class="section_body">
        <div class="card">
            <form action="{{ url('faq_category/'.$faq_category->id) }}" method="post" enctype="multipart/form-data" onsubmit="return encodeField();">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-form-label">{{__('FAQ Category Title')}}</label>
                        <input type="text" required value="{{ old('name',$faq_category->name) }}" name="name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label class="col-form-label">{{__('FAQ Sort No')}}</label>
                        <input type="number" required value="{{ old('sort_cat',$faq_category->sort_cat) }}" name="sort_cat" class="form-control @error('sort_cat') is-invalid @enderror">
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