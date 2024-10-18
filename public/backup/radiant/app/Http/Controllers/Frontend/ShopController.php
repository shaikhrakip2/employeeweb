<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\BookingInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
  
    
    public function shop(Request $request, $slug = '')
    {
        
        $categories = Category::all()->where('status',1);

        $category = Category::where('status', '1')
        ->whereNull('deleted_at')
        ->where('status', '1')
        ->get();  


        $footer_cat = Category::where('status', '1')
        ->whereNull('deleted_at')
        ->where('status', '1')
        ->get();  
      
        $query = Product::select('products.id', 'products.name','categories.name as catname','products.sort_description','products.default_image','products.slug' /* add other columns as needed */)
        ->leftJoin('product_to_categories', 'product_to_categories.product_id', '=', 'products.id')
        ->leftJoin('categories', 'product_to_categories.product_id', '=', 'categories.id');
    
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        } else {
            $query->whereNotNull('category_id');
        }
        

    
    $query->groupBy('products.id','products.name','catname','products.default_image','products.sort_description','products.slug' /* add other columns as needed */);
    
    $productsData = $query->paginate(10);

        return view('frontend.shop', compact('productsData','footer_cat','category','categories'));
    }




}
