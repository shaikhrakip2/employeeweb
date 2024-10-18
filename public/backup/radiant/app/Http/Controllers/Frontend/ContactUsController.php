<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\GeneralInquiry;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Cms;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Contact Us';

        $category = Category::where('status', '1')
        ->whereNull('deleted_at')
        ->where('status', '1')
        ->get();
        
        $contactCms = Cms::where('id', '5')->where('status',1)->first();
        return view('frontend.contact_us', compact('title','category','contactCms'));
    }

    public function submitcontact(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:30',
            'email' => 'required|email',
            'mobile' => 'required|numeric|min:10',
            'message' => 'required',
        ]);
        
        try {
            $data = new GeneralInquiry();
            $data->name = $request->name;
            $data->email = $request->email;
            $data->mobile = $request->mobile;
            $data->message = $request->message;
            $data->save();

            $request->session()->flash('success', 'Thanks For Contacting Us');
            return redirect()->route('contact_us')->with('scroll_to', 'contact-scroll');
        } catch (\Exception $e) {
            $errorMessage = 'Failed to save contact inquiry: ' . $e->getMessage();
            return redirect()->back()->with('error', $errorMessage);
        }
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_img('flat')]);
    }
}
