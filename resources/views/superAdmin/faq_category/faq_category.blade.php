@extends('layout.mainlayout_admin',['activePage' => 'radiology_category'])

@section('title',__('FAQ Category'))

@section('content')
<section class="section">
    @include('layout.breadcrumb',[
        'title' => __('FAQ Category List'),
    ])
    <div class="section_body">
        @if (session('status'))
        @include('superAdmin.auth.status',[
            'status' => session('status')])
        @endif
        <div class="card">
            <div class="card-header w-100 text-right d-flex justify-content-between">
                @include('superAdmin.auth.exportButtons')
                @can('lab_add')
                    <a href="{{  url('faq_data') }}">{{ __('View FAQs') }}</a>                
                    <a href="{{  url('faq_category/create') }}">{{ __('Add New') }}</a>                
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table table-hover table-center mb-0">
                        <thead>
                            <tr>
                                <th>
                                    <input name="select_all" value="1" id="master" type="checkbox" />
                                    <label for="master"></label>
                                </th>
                                <th>#</th>
                                <th>Sort No</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Status')}}</th>
                                @if (Gate::check('radiology_category_edit') || Gate::check('radiology_category_delete'))
                                    <th>{{__('Actions')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faqCategories as $faqCategory)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="id[]" value="{{$faqCategory->id}}" id="{{$faqCategory->id}}" data-id="{{ $faqCategory->id }}" class="sub_chk">
                                        <label for="{{$faqCategory->id}}"></label>
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $faqCategory->sort_cat }}</td>
                                    <td>{{ $faqCategory->name }}</td>
                                    <td>
                                        <label class="cursor-pointer">
                                            <input type="checkbox"id="status_1{{$faqCategory->id}}" class="custom-switch-input" onchange="change_status('faq_category',{{ $faqCategory->id }})" {{ $faqCategory->status == 1 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </td>
                                    <td>
                                        @if (Gate::check('radiology_category_edit') || Gate::check('radiology_category_delete'))
                                            @can('radiology_category_edit')
                                            <a class="text-success" href="{{url('faq_category/'.$faqCategory->id.'/edit')}}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('radiology_category_delete')
                                            <a class="text-danger" href="javascript:void(0);" onclick="deleteData('faq_category',{{ $faqCategory->id }})">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                            @endcan
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card_fotter">
                <input type="button" value="delete selected" onclick="deleteAll('faq_cat_all_delete')" class="btn btn-primary">
            </div>
        </div>
    </div>
</section>
@endsection