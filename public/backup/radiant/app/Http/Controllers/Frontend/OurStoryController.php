<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use App\Models\DoctorDescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class OurStoryController extends Controller
{
    public function index(Request $request)
    {
        
        $title = 'Our Story';
        $doctors = DoctorDescription::where('status', 1)->orderBy('sort_order', 'asc')->paginate(4);
            
        return view('frontend.our_story', compact('title','doctors'));
    }

    public function loadMoreDoctors(Request $request)
    {
        $perPage = 4 ; // Number of testimonials per page
        $page = $request->input('page');
        $offset = ($page - 1) * $perPage;

        $doctors = DoctorDescription::skip($offset)->take($perPage)->where('status', 1)->orderBy('sort_order', 'asc')->get()->toArray();
        // $testimonials = Testimonial::paginate(5, ['*'], 'page', $page);
        // dd($testimonials);
        
        $doctors = View::make('frontend.partials.doctor_description_pagination', compact('doctors'))->render();
        // dd($doctors);
        return response()->json(['doctors' => $doctors],200);
    }
}
