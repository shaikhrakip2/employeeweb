<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrivacyPolicyController extends Controller
{
    public function index(Request $request)
    {
        
        $title = 'Privacy Policy';
        $cmsprivacy = Cms::where('id', '2')->where('status',1)->first();

        $category = Category::where('status', '1')
        ->whereNull('deleted_at')
        ->where('status', '1')
        ->get();
        
        $footer_cat = Category::where('status', '1')
        ->whereNull('deleted_at')
        ->where('status', '1')
        ->get();  

            
        return view('frontend.privacy_policy', compact('title','footer_cat','category','cmsprivacy'));
    }

}
