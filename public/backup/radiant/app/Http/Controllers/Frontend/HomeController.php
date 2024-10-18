<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\HomeCms;

use App\Models\Product;
use App\Models\Category;
use App\Models\DoctorDescription;
use App\Models\Event;
use App\Models\NewsLetter;
use App\Models\SaveLittle;
use App\Models\Team;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
       $banners = Banner::select('id', 'name', 'title', 'image', 'status')->where(array('type'=> 1,'status'=>1))
            ->whereNull('deleted_at')
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();

        $save_littles = SaveLittle::where('status', '1')->orderBy('sort_order', 'asc')->get()->toArray();
        $doctors = DoctorDescription::where('status', '1')->orderBy('sort_order', 'asc')->take(10)->get()->toArray();

        $team_members = Team::where('status', '1')->orderBy('sort_order', 'asc')->take(8)->get()->toArray();
        
        $testimonials = Testimonial::where('status', '1')
        ->whereNull('deleted_at')
        ->orderBy('sort_order', 'asc')
        ->take(6)
        ->get()
        ->toArray();
        
        $events = Event::where('status', '1')
        ->whereNull('deleted_at')
        ->orderBy('sort_order', 'asc')
        ->get();

        $blogs = Blog::where('status', '1')
        ->whereNull('deleted_at')
        ->orderBy('sort_order', 'asc')
        ->get();
        
        $is_featured_category = Category::where('status', '1')
        ->whereNull('deleted_at')
        ->orderBy('sort_order', 'asc')
        ->where('is_featured', '1')
        ->get();  


        $is_trending_product = Product::where('status', '1')
        ->whereNull('deleted_at')
        ->orderBy('sort_order', 'asc')
        ->where('is_trending', '1')
        ->get();  

        $is_top_product = Product::where('status', '1')
        ->whereNull('deleted_at')
        ->orderBy('sort_order', 'asc')
        ->where('is_top', '1')
        ->get();  

        $footer_cat = Category::where('status', '1')
        ->whereNull('deleted_at')
        ->where('status', '1')
        ->get();  
    
        $save_little_homeCms = HomeCms::where('id', '1')->first(); 
        $our_story_homeCms = HomeCms::where('id', '2')->first(); 
        $our_team_homeCms = HomeCms::where('id', '3')->first();
        $testimonial_homeCms = HomeCms::where('id', '4')->first();
        $event_homeCms = HomeCms::where('id', '5')->first();
        $blog_homeCms = HomeCms::where('id', '6')->first();

        $title = 'Ad Enterprises Home Page';
        return view('frontend.index', compact('events','doctors','save_littles','team_members','blogs','title', 'banners','our_story_homeCms','our_team_homeCms','testimonial_homeCms','event_homeCms','blog_homeCms','save_little_homeCms','footer_cat','is_trending_product','is_top_product','is_featured_category','testimonials'));
    }

  
}
