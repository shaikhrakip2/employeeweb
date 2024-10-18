<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WholesaleController extends Controller
{
    public function index(Request $request)
    {
       
        $title = 'Wholesale';
        $cmswholesale = Cms::where('id', '5')->where('status',1)->first();

        $footer_cat = Category::where('status', '1')
        ->whereNull('deleted_at')
        ->where('status', '1')
        ->get();  

        return view('frontend.wholesale', compact('title','footer_cat','cmswholesale'));
    }

}
