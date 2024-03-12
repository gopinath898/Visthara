<?php

namespace App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function submitQuery(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'email' => 'bail|required|email|unique:users',
            'phone' => 'bail|required|numeric|digits_between:6,12',
            // 'subject' => 'bail|required',
            'message' => 'bail|required',
            // 'termsChecked' => 'bail|required'
        ]);
        $data = $request->all();

        $response = Enquiry::create($data);
        return response()->json(['success' => true, 'message' => 'Message submitted. We will get in touch with you soon.']);
    }

    public function enquiries(){
        $enquiries = Enquiry::all();
        return view('superAdmin.patient.enquiries',compact('enquiries'));
    }
}
?>