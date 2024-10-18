<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\PhotoGalleryImage;
use Yajra\DataTables\Facades\DataTables;

class GalleryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:admin');
        checkPermission($this, 120);
    }

    public function index(Request $request)
    {
        if($request->ajax()) {
            $records = Gallery::select('id','name','default_image', 'status')->where([['deleted_at', NULL]])->get();
            return DataTables::of($records)
            ->addColumn('status', function($row) {
                $status = ($row->status == 1)? 'checked': '';
                return $statusBtn = '<input class="tgl_checkbox tgl-ios" 
                data-id="'.$row->id.'" 
                id="cb_'.$row->id.'"
                type="checkbox" '.$status.'><label for="cb_'.$row->id.'"></label>';  
            })
            ->addColumn('action', function($row) {
                return $action_btn = '<a href="'.url('admin/gallery/'.$row->id.'/edit').'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                <button data-id="'.$row->id.'" class="btn btn-sm btn-danger delete_record"><i class="fa fa-trash"></i> Delete</button>'; 
            }) 
            ->editColumn('default_image', function($row) {
                return '<img src="'.asset($row->default_image).'" class="image logosmallimg">';
            })
            ->removeColumn('id') 
            ->rawColumns(['status','default_image','action'])->make(true);
        }
        $title = "Gallery";
        return view('admin.gallery.index', compact('title'));
    }
    public function create()
    {
        $title = "Add Gallery";  
        return view('admin.gallery.add', compact('title'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name'  => 'required|max:250',
            'sort_order'  => 'required|numeric',
            'default_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image.*.media' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = new Gallery;
        $data->name = $request->name;
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
        $data->slug = $slug;
        $data->sort_order = $request->sort_order;
        $gallery_image =$data->default_image;
        $destinationPath    = UPLOADFILES.'gallery/';
        if($file = $request->file('default_image')) {
            if(!empty($request->old_image)){  
                delete_file($destinationPath.$request->old_image);
            } 
            $uploadImage        = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $uploadImage);
            $gallery_image = $destinationPath.$uploadImage;
            $data->default_image = $gallery_image;
        }
        $data->save();

        if ($request->has('image')) {
            foreach ($request->image as $imageData) {
                $image = new GalleryImage;
                $image->photo_id = $data->id;
                $image->sort_order = $imageData['sort_order'];
                $file = $imageData['media'];
                $uploadImage = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $uploadImage);
                $image->image = $destinationPath . $uploadImage;
                $image->save();
            }
        }
        $request->session()->flash('success','Photo Gallery Added Successfully!!'); 
        return redirect( url('admin/gallery'));
    }

    public function edit(Request $request, $id)
    {
        $title = "Edit Gallery";   
        $data = Gallery::where('id', $id)->first();
        $media = GalleryImage::where('photo_id', $id)->get()->toArray();
        if(!empty($data)){
            return view('admin.gallery.edit', compact('title','data','media'));
        }else{
            $title = "404 Error Page";
            $message = '<i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found!!';
            return view('admin.error', compact('title','message'));
        }
    }

    public function update(Request $request, $id)
    { 
        $validate = $request->validate([
            'name'  => 'required|max:250',
            'sort_order'  => 'required|numeric',
            'default_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image.*.media' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = Gallery::where('id', $id)->first();
        if ($data) {
            $data->name = $request->name;
            $data->sort_order = $request->sort_order;
            $gallery_image =$data->default_image;
            $destinationPath    = UPLOADFILES.'gallery/';
            if($file = $request->file('default_image')) {
                if(!empty($request->old_image)){  
                    delete_file($request->old_image);
                } 
                $uploadImage        = time().'.'.$file->getClientOriginalExtension();
                $file->move($destinationPath, $uploadImage);
                $gallery_image = $destinationPath.$uploadImage;
            }
            $data->default_image = $gallery_image;
            $data->save();

            GalleryImage::where('photo_id', $id)->delete();
            // dd($img);
            if ($request->has('image')) {
                foreach ($request->image as $imageData) {
                    $image = new GalleryImage;
                    $image->photo_id = $data->id;
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
         
            $request->session()->flash('success','Photo Gallery Update Successfully!!');
            return redirect(url('admin/gallery'));
        }else {
            $request->session()->flash('error','Photo Gallery Does Not Exist!!');
            return redirect(url('admin/gallery'));
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = Gallery::where('id', $id)->delete();              
        }else{
            return 0;
        }
    }

    public function change_status(Request $request)
    {
        if ($request->ajax()) {
            $data = Gallery::where('id', $request->id)->first();
            $data->status = $data->status==1?0:1;
            $data->save();
        }
    }
}
