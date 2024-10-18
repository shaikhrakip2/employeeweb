<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Validator;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;

use App\Models\ProductToCategory;

use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Only Authenticated users for "admin" guard
     * are allowed.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:admin');
        checkPermission($this, 113);
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $records = Product::select('id', 'slug', 'name', 'default_image', 'status')
                ->get();

            return Datatables::of($records)

                ->addColumn('status', function ($row) {
                    $status = ($row->status == 1) ? 'checked' : '';
                    return $statusBtn = '<input class="tgl_checkbox tgl-ios"
                data-id="' . $row->id . '"
                id="cb_' . $row->id . '"
                type="checkbox" ' . $status . '><label for="cb_' . $row->id . '"></label>';
                })
                ->addColumn('action', function ($row) {
                    $action_btn = '';

                    $action_btn .= '<a href="' . url('admin/product/' . $row->id . '/edit') . '" class="btn btn-sm btn-primary m-1" title="Edit"><i class="fa fa-edit"></i></a>';


                    $action_btn .=   '<button data-id="' . $row->id . '" class="btn btn-sm btn-danger delete_record" title="Delete"><i class="fa fa-trash"></i></button>';

                    return $action_btn;
                })
                ->editColumn('default_image', function ($row) {
                    return '<img src="' . asset($row->default_image) . '" class="image logosmallimg">';
                })
                ->removeColumn('id')
                ->rawColumns(['status', 'default_image', 'action'])->make(true);
        }
        $title = "Product";
        return view('admin.product.index', compact('title'));
    }

    public function create()
    {
        
        $title = "Add Product";
   

        $category = new Category();
        $parcat = $category->getparentCat(1);
  

        $rProducts = Product::where([['status', '1'],['deleted_at', NULL]])->get();

     
        return view('admin.product.add', compact('title','parcat','rProducts'));

    }

    public function store(Request $request)
    {
       
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
        $validate = $request->validate([
            'name' => 'required|unique:products',
            'description' => 'required',
            'sort_description' => 'required',

            'category_id' => 'required',
            'sort_order' => 'required|numeric',

            'default_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image.*.media' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

       
        $data = new Product;
        $data->slug = $slug;
        $data->name = $request->name;
        $data->sort_order = $request->sort_order;
        $data->is_top = $request->is_top;
        $data->is_trending = $request->is_trending;

        $data->sort_description = $request->sort_description;
        $data->full_description = $request->description;
        $data->status = 1;
        $Category_image = '';
        $destinationPath    = UPLOADFILES . 'product/';
        if ($file = $request->file('default_image')) {
            $uploadImage        = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $uploadImage);
            $Category_image = $destinationPath . $uploadImage;
            $data->default_image = $Category_image;
        }
        
        $data->save();

        if ($request->has('image')) {
            foreach ($request->image as $imageData) {
                $image = new ProductImage;
                $image->product_id = $data->id;
                $image->sort_order = $imageData['sort_order'];

                $file = $imageData['media'];
                $uploadImage = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $uploadImage);

                $image->image = $destinationPath . $uploadImage;
                $image->save();
            }
        }

        if(!empty($request['category_id'])){
            $maincategory = explode(',',$request['category_id']);

            foreach($maincategory as $key=>$catData)
            {
                $category = new ProductToCategory;
                $category->product_id = $data->id;
                $category->category_id = $catData;
                $category->save();
            }
        }

        $request->session()->flash('success', 'Product Added Successfully!!');
        return redirect(url('admin/product'));
    }

    public function edit(Request $request, $id)
    {
        $title = "Edit Product";
        $data = Product::where('id', $id)->first();
        $media = ProductImage::where('product_id', $id)->get()->toArray();

        $category = new Category();
        $parcat = $category->getparentCat(1);
             
        $products =  new Product();
        $procategory = $products->get_product_category($id); 

    
        if (!empty($data)) {
            return view('admin.product.edit', compact('title','parcat', 'data', 'media','procategory'));
        } else {
            $title = "404 Error Page";
            $message = '<i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found!!';
            return view('admin.error', compact('title', 'message'));
        }
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required|unique:products,name,' . $id,
            'description' => 'required',
            'sort_description' => 'required',
            'category_id' => 'required',
            'sort_order' => 'required|numeric',
            'default_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image.*.media' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

    

        $data = Product::where('id', $id)->first();
    
        if ($data) {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
            $data->slug = $slug;
            $data->name = $request->name;
            $data->is_top = $request->is_top;
            $data->is_trending = $request->is_trending;
            
            $data->sort_order = $request->sort_order;
            $data->sort_description = $request->sort_description;
            $data->full_description = $request->description;

            $destinationPath    = UPLOADFILES . 'product/';
            $Category_image = $data->default_image;
            if ($file = $request->file('default_image')) {
                if (!empty($request->old_image)) {
                    delete_file($request->old_image);
                }
                $uploadImage        = time() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $uploadImage);
                $Category_image = $destinationPath . $uploadImage;
            }
            $data->default_image = $Category_image;
            $data->save();

            ProductImage::where('product_id', $id)->delete();
            if ($request->has('image')) {
                foreach ($request->image as $imageData) {
                    $image = new ProductImage;
                    $image->product_id = $data->id;
                    $image->sort_order = $imageData['sort_order'];
                    if (!empty($imageData['media'])) {
                        $file = $imageData['media'];
                        $uploadImage = uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move($destinationPath, $uploadImage);

                        $image->image = $destinationPath . $uploadImage;
                    } else {
                        if (!empty($imageData['old_media'])) {
                            $image->image = $imageData['old_media'];
                        }
                    }


                    $image->save();
                }
            }
  
            if(!empty($request['category_id'])){
                $procat = explode(',', $request['category_id']);
                ProductToCategory::where('product_id', $id)->delete();
                foreach ($procat as $key => $catData) {
                    $category = new ProductToCategory();
                    $category->product_id   = $data->id;
                    $category->category_id  = $catData;
                    $category->save();
                }
            }
           
            $request->session()->flash('success', 'Product Update Successfully!!');
            return redirect(url('admin/product'));
        } else {
            $request->session()->flash('error', 'Product Does Not Exist!!');
            return redirect(url('admin/product'));
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = Product::where('id', $id)->delete();
            ProductImage::where('product_id', $id)->delete();
        } else {
            return 0;
        }
    }

    public function change_status(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::where('id', $request->id)->first();
            $data->status = $data->status == 1 ? 0 : 1;
            $data->save();
        }
    }

 
}
