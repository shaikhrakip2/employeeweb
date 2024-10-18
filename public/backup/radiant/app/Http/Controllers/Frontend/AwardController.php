<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use App\Models\DoctorDescription;
use App\Models\Award;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class AwardController extends Controller
{
    public function index(Request $request)
    {
        
        $title = 'Our Awards';
        $awards = Award::where('status', 1)->orderBy('date', 'desc')->paginate(6);
            
        return view('frontend.awards', compact('title','awards'));
    }

    public function loadMoreAwards(Request $request)
    {
        $perPage = 6; // Number of testimonials per page
        $page = $request->input('page');
        $offset = ($page - 1) * $perPage;

        $awards = Award::skip($offset)->take($perPage)->where('status', 1)->orderBy('date', 'desc')->get()->toArray();
        // $testimonials = Testimonial::paginate(5, ['*'], 'page', $page);
        // dd($testimonials);
        
        $awards = View::make('frontend.partials.award_pagination', compact('awards'))->render();
        // dd($awards);
        return response()->json(['awards' => $awards],200);
    }
}
