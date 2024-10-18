<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use App\Models\NewsLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DonateController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Donate';
        $cmsdonation = Cms::where('id', '8')->where('status',1)->first(); 
        return view('frontend.donate', compact('title','cmsdonation'));
    }

}
