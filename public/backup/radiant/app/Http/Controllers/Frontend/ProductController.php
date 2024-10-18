<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\BookingInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{


    public function productDetails($slug = '')
    {
        $title = "Product Details";

        // $accessorydetails = Product::select('products.*')
        //     ->with(['product_images' => function ($query) {
        //         $query->take(9);}])
        //     ->where('products.slug', $slug)
        //     ->where('products.status', '1')
        //     ->get();


        $footer_cat = Category::where('status', '1')
        ->whereNull('deleted_at')
        ->where('status', '1')
        ->get();  



        $product_name = Product::select('products.*')->where('slug',$slug)->get();
        $productid = $product_name[0]['id'];
        $productname = $product_name[0]['name'];
           
        // dd($accessorydetails->toArray());


        // $data = Product::where('slug', $slug)->first();

        $data = Product::where('slug', $slug) ->first();

        $product_image = ProductImage::where('product_id',$productid)->OrderBy('sort_order')->get();
       
            // dd($datas);
        return view('frontend.productdetails', compact('title','footer_cat', 'data','product_image','productname','productid'));

    }

    public function submitproductinquiry(Request $request)
    {
        // try {
            $validate = $request->validate([
                'name' => 'required|max:30',
                'email' => 'required|email',
                'mobile' => 'required|numeric|min:10',
                'message' => 'required',
                'captcha' => 'required|captcha',
            ], [
                'name.required' => 'Please enter your name.',
                'name.max' => 'The name should not exceed 30 characters.',
                'email.required' => 'Please enter your email address.',
                'email.email' => 'Please enter a valid email address.',
                'mobile.required' => 'Please enter your mobile number.',
                'mobile.numeric' => 'Mobile number should be numeric.',
                'mobile.min' => 'Mobile number should be at least 10 digits.',
                'message.required' => 'Please enter your message.',
                'captcha.required' => 'Please enter the captcha value.',
                'captcha.captcha' => 'The captcha value entered is incorrect.',
            ]);

            $data = new BookingInquiry();
            $data->name = $request->name;
            $data->email = $request->email;
            $data->mobile = $request->mobile;
            $data->message = $request->message;
            // $slug = $request->slug;
            $data->product_id = $request->pid;
            $data->save();

            $request->session()->flash('success', 'Thanks for Product Inquiry');
            // return redirect()->route('productDetails');
            return redirect()->back();
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     dd($e);
        //     // If captcha validation failed, set a specific error message
        //     if ($e->validator->errors()->has('captcha')) {
        //         $request->session()->flash('captcha_error', 'The captcha value entered is incorrect.');
        //         return redirect()->back()->withInput();
        //     } else {
        //         // Handle other validation errors
        //         $request->session()->flash('error', 'Failed to save Book inquiry: ' . $e->getMessage());
        //         return redirect()->back()->withInput();
        //     }
        // }
    }


    public function products(Request $request, $slug = Null)
    {
        // $allproducts = Product::where('status', '1')
        //     ->whereNull('deleted_at')
        //     ->orderBy('sort_order', 'asc')
        //    ->get();
        $categories = Category::where(['status' => 1])
        ->whereNull('deleted_at')
        ->get()
        ->toArray();

        $categories_obj = new Category;
        $cats = $categories_obj->getCategories();

        $activecategory = Category::select('*')
        ->where('slug', $slug)
        ->where('status',1)
        ->get();

        $footer_cat = Category::where('status', '1')
        ->whereNull('deleted_at')
        ->where('status', '1')
        ->get();

        $category = $footer_cat;  
      
        $query = Product::select('products.id','categories.slug as catslug', 'products.name','categories.name as catname','products.sort_description','products.default_image','products.slug' /* add other columns as needed */)
        ->leftJoin('product_to_categories', 'product_to_categories.product_id', '=', 'products.id')
        ->leftJoin('categories', 'product_to_categories.product_id', '=', 'categories.id');
    
        if (!empty($slug)) {
        $query = Product::select('products.id','categories.slug as catslug', 'products.name','categories.name as catname','products.sort_description','products.default_image','products.slug' /* add other columns as needed */)
        ->leftJoin('product_to_categories', 'product_to_categories.product_id', '=', 'products.id')
        ->leftJoin('categories', 'categories.id', 'product_to_categories.category_id');

            $query->where('categories.slug', $slug);
        } 
    
        $query->where('products.status', 1);
        $query->groupBy('products.id','catslug','products.name','catname','products.default_image','products.sort_description','products.slug' /* add other columns as needed */);

        // dd($slug, $query->get()->toArray());
    
        $productsData = $query->paginate(9);

        return view('frontend.products', compact('productsData','slug','activecategory','cats','footer_cat','category','categories'));
    }


    public function products1(Request $request, $slug = '')
    {
     
    
        $limit = '';
        if (!empty($request->booklimit)) {
            $limit = $request->booklimit;
        } else {
            $limit = 12;
        }

        if (!empty($slug)) {
            $category_data = Category::select('id')->where('slug', $slug)->get()->first();
        }
        $search = urldecode($request->search);

        DB::statement("SET SQL_MODE = ''");



            $allbooks = Product::where('status', '1')
            ->leftjoin('product_to_categories', 'product_to_categories.product_id', '=', 'products.id')
            ->whereNull('deleted_at')
            ->orderBy('sort_order', 'asc')
            ->where('is_top', '1');
              

   
        if (!empty($slug)) {
            $allbooks->where([['products.status', 1], ['product_to_categories.category_id', $category_data->id]]);
        }


        if (!empty($request->booklimit)) {
            $allbooks->limit($limit);
        }

        $allbooks = $allbooks->groupBy('id')->paginate($limit);
        // dd($allbooks);
        $book_counts = Product::select('*')->where('status', 1)->count();

        $allcategory = Category::select('*')
            ->where('status', 1)
            ->get();

        $categories_obj = new Category;
        $cats = $categories_obj->getCategories();

        $activecategory = Category::select('*')
            ->where('id', 0)
            ->get();

            
        $footer_cat = Category::where('status', '1')
        ->whereNull('deleted_at')
        ->where('status', '1')
        ->get();  

        return view('frontend.products1', compact('allbooks','footer_cat', 'allcategory', 'activecategory', 'book_counts', 'limit', 'cats'));
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_img('flat')]);
    }




}
