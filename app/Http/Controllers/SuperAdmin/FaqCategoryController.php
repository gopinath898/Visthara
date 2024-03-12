<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class FaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('radiology_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $faqCategories = FaqCategory::orderBy('sort_cat','ASC')->get();
        return view('superAdmin.faq_category.faq_category',compact('faqCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('radiology_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('superAdmin.faq_category.create_faq_category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required'
        ]);
        $data = $request->all();
        $data['status'] = 1;
        FaqCategory::create($data);
        return redirect('/faq_category')->withStatus(__('FAQ Category Created Successfully.!'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('radiology_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $faq_category = FaqCategory::find($id);
        return view('superAdmin.faq_category.edit_faq_category',compact('faq_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'bail|required'
        ]);
        $request->merge([
            'description'=>base64_decode($request->description)
        ]);
        FaqCategory::find($id)->update($request->all());
        return redirect('/faq_category')->withStatus(__('Faq Category updated Successfully.!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        FaqCategory::find($id)->delete();
        return ['success' => true];
    }
    
    public function change_status(Request $reqeust)
    {
        $faq_category = FaqCategory::find($reqeust->id);
        $data['status'] = $faq_category->status == 1 ? 0 : 1;
        $faq_category->update($data);
        return response(['success' => true]);
    }
}
