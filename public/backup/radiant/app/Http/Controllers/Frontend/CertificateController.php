<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Certification';

        DB::statement("SET SQL_MODE = ''");
        $certificateData = Certification::select('*')
            ->where('status', '1')
            ->groupBy('id', 'name')
            ->get()->toArray();


            $category = Category::where('status', '1')
            ->whereNull('deleted_at')
            ->where('status', '1')
            ->get(); 
            
            $footer_cat = Category::where('status', '1')
            ->whereNull('deleted_at')
            ->where('status', '1')
            ->get();  


        // dd($certificateData);

        return view('frontend.certificate', compact('title','footer_cat','category','certificateData'));
    }

}
