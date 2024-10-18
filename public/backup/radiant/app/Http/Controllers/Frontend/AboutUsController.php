<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use App\Models\Product;
use App\Models\Category;
use App\Models\HomeCms;
use App\Models\SaveLittle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AboutUsController extends Controller
{
    public function index(Request $request)
    {
        
        $title = 'About Us';
        $cmsaboutus = Cms::where('id', '1')->where('status',1)->first(); 
        $save_little_homeCms = HomeCms::where('id', '1')->first(); 
        $save_littles = SaveLittle::where('status', '1')->orderBy('sort_order', 'asc')->get()->toArray();
        return view('frontend.about_us', compact('title','cmsaboutus','save_littles','save_little_homeCms'));
    }

}
