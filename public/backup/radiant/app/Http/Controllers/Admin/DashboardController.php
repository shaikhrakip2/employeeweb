<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;



use App\Models\Testimonial;
use App\Models\GeneralInquiry;
use App\Models\BookingInquiry;

class DashboardController extends Controller
{
    /**
     * Only Authenticated users for "admin" guard 
     * are allowed.
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:admin');
        checkPermission($this, 102);
    }

    /**
     * Show Admin Dashboard.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $title = "Dashboard";
        $admincount = Admin::where([['deleted_at', NULL]])->where([['id', '!=', 1]])->count();



  

        $testimonialcount = Testimonial::where([['deleted_at', NULL]])->count();
        $generalInquirycount = GeneralInquiry::where([['deleted_at', NULL]])->count();
        $bookingInquirycount = BookingInquiry::where([['deleted_at', NULL]])->count();
        
       

  

        return view('admin.dashboard', compact('title','generalInquirycount','bookingInquirycount', 'admincount','testimonialcount'));
    }

    public function permission_denied(Request $request)
    {
        $title = "Permission Denied";
        $message = "You Don’t Have Permission To Access Module, Please Contact To Administrator For More Information";
        return view('admin.error', compact('title', 'message'));
    }
}
