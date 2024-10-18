<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use App\Models\DoctorDescription;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        
        $title = 'Our Team';
        $team_members = Team::where('status', 1)->orderBy('sort_order', 'asc')->paginate(8);
            
        return view('frontend.team', compact('title','team_members'));
    }

    public function loadMoreTeamMembers(Request $request)
    {
        $perPage = 8; // Number of testimonials per page
        $page = $request->input('page');
        $offset = ($page - 1) * $perPage;

        $team_members = Team::skip($offset)->take($perPage)->where('status', 1)->orderBy('sort_order', 'asc')->get()->toArray();
        // $testimonials = Testimonial::paginate(5, ['*'], 'page', $page);
        // dd($testimonials);
        
        $team_members = View::make('frontend.partials.team_pagination', compact('team_members'))->render();
        // dd($team_members);
        return response()->json(['team_members' => $team_members],200);
    }
}
