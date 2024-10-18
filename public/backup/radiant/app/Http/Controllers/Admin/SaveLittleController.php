<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Validator; 
use App\Models\SaveLittle; 
use Yajra\DataTables\Facades\DataTables;

class SaveLittleController extends Controller
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
        checkPermission($this, 116);
    }


    public function index(Request $request)
    {
        if($request->ajax()) {
            $records = SaveLittle::select('id','name','image', 'status')->where([['deleted_at', NULL]])->get();

            return Datatables::of($records)
            ->addColumn('status', function($row) {
                $status = ($row->status == 1)? 'checked': '';
                return $statusBtn = '<input class="tgl_checkbox tgl-ios" 
                data-id="'.$row->id.'" 
                id="cb_'.$row->id.'"
                type="checkbox" '.$status.'><label for="cb_'.$row->id.'"></label>';  
            })
            ->addColumn('action', function($row) {
                return $action_btn = '<a href="'.url('admin/save-littles/'.$row->id.'/edit').'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                <button data-id="'.$row->id.'" class="btn btn-sm btn-danger delete_record"><i class="fa fa-trash"></i> Delete</button>'; 
            }) 
            ->editColumn('image', function($row) {
                return '<img src="'.asset($row->image).'" class="image logosmallimg">';
            })
            ->removeColumn('id') 
            ->rawColumns(['status','image','action'])->make(true);
        }
        $title = "Save Littles";
        return view('admin.save_littles.index', compact('title'));
    }


    public function create()
    {
        $title = "Add Save Little";  
        return view('admin.save_littles.add', compact('title'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
             'name' => 'required|max:250|unique:save_littles,name',
             'description'  => 'required',
             'sort_order'  => 'required|numeric|',
             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]); 

        $data = new SaveLittle;
        $data->name = $request->name;
        $data->description = $request->description;
        $data->sort_order = $request->sort_order;
        $SaveLittle_image =$data->image;
        if($file = $request->file('image')) {
            $destinationPath    = UPLOADFILES.'save_littles/';
            if(!empty($request->old_image)){  
                delete_file($destinationPath.$request->old_image);
            } 
            $uploadImage        = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $uploadImage);
            $SaveLittle_image = $destinationPath.$uploadImage;
        }
        $data->image = $SaveLittle_image; 
        $data->save();


        $request->session()->flash('success','Save Little Added Successfully!!'); 
        return redirect( url('admin/save-littles'));
    }



    public function edit(Request $request, $id)
    {
        $title = "Edit Save Little";   
        $data = SaveLittle::where('id', $id)->first();
        if(!empty($data)){
            return view('admin.save_littles.edit', compact('title','data'));
        }else{
            $title = "404 Error Page";
            $description = '<i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found!!';
            return view('admin.error', compact('title','description'));
        }
    }

    public function update(Request $request, $id)
    { 
        $validate = $request->validate([
         'name'                => "required|max:250|unique:save_littles,name,$id",
         'description'         => 'required|',
         'sort_order'          => 'required|numeric|',
         'image'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = SaveLittle::where('id', $id)->first();
        if ($data) {
            $data->name = $request->name;
            $data->description = $request->description;
            $data->sort_order = $request->sort_order;

            $SaveLittle_image =$data->image;
            if($file = $request->file('image')) {
                $destinationPath    = UPLOADFILES.'save_littles/';
                if(!empty($request->old_image)){  
                    delete_file($request->old_image);
                } 
                $uploadImage        = time().'.'.$file->getClientOriginalExtension();
                $file->move($destinationPath, $uploadImage);
                $SaveLittle_image = $destinationPath.$uploadImage;
            }
            $data->image = $SaveLittle_image;
            
            $data->save();

            $request->session()->flash('success','Save Little Update Successfully!!');
            return redirect(url('admin/save-littles'));
        }else {
            $request->session()->flash('error','Save Little Does Not Exist!!');
            return redirect(url('admin/save-littles'));
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = SaveLittle::where('id', $id)->delete();              
        }else{
            return 0;
        }
    }

    public function change_status(Request $request)
    {
        if ($request->ajax()) {
            $data = SaveLittle::where('id', $request->id)->first();
            $data->status = $data->status==1?0:1;
            $data->save();
        }
    }
}
