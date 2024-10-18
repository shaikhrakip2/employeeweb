<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Validator; 
use App\Models\DoctorDescription; 
use Yajra\DataTables\Facades\DataTables;

class DoctorDescriptionController extends Controller
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
            $records = DoctorDescription::select('id','name', 'qualification','image', 'status')->where([['deleted_at', NULL]])->get();

            return Datatables::of($records)
            ->addColumn('status', function($row) {
                $status = ($row->status == 1)? 'checked': '';
                return $statusBtn = '<input class="tgl_checkbox tgl-ios" 
                data-id="'.$row->id.'" 
                id="cb_'.$row->id.'"
                type="checkbox" '.$status.'><label for="cb_'.$row->id.'"></label>';  
            })
            ->addColumn('action', function($row) {
                return $action_btn = '<a href="'.url('admin/doctor-descriptions/'.$row->id.'/edit').'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                <button data-id="'.$row->id.'" class="btn btn-sm btn-danger delete_record"><i class="fa fa-trash"></i> Delete</button>'; 
            }) 
            ->editColumn('image', function($row) {
                return '<img src="'.asset($row->image).'" class="image logosmallimg">';
            })
            ->removeColumn('id') 
            ->rawColumns(['status','image','action'])->make(true);
        }
        $title = "Doctor Descriptions";
        return view('admin.doctor_descriptions.index', compact('title'));
    }


    public function create()
    {
        $title = "Add Doctor Description";  
        return view('admin.doctor_descriptions.add', compact('title'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
             'name' => 'required|max:250|unique:doctor_descriptions,name',
             'qualification' => 'required|max:250',
             'description'  => 'required',
             'sort_order'  => 'required|numeric|',
             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]); 

        $data = new DoctorDescription;
        $data->name = $request->name;
        $data->qualification = $request->qualification;
        $data->description = $request->description;
        $data->sort_order = $request->sort_order;
        $DoctorDescription_image =$data->image;
        if($file = $request->file('image')) {
            $destinationPath    = UPLOADFILES.'doctor_descriptions/';
            if(!empty($request->old_image)){  
                delete_file($destinationPath.$request->old_image);
            } 
            $uploadImage        = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $uploadImage);
            $DoctorDescription_image = $destinationPath.$uploadImage;
        }
        $data->image = $DoctorDescription_image; 
        $data->save();


        $request->session()->flash('success','DoctorDescription Added Successfully!!'); 
        return redirect( url('admin/doctor-descriptions'));
    }



    public function edit(Request $request, $id)
    {
        $title = "Edit Doctor Description";   
        $data = DoctorDescription::where('id', $id)->first();
        if(!empty($data)){
            return view('admin.doctor_descriptions.edit', compact('title','data'));
        }else{
            $title = "404 Error Page";
            $description = '<i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found!!';
            return view('admin.error', compact('title','description'));
        }
    }

    public function update(Request $request, $id)
    { 
        $validate = $request->validate([
         'name'                => "required|max:250|unique:doctor_descriptions,name,$id",
         'qualification'       => 'required|max:250',
         'description'         => 'required|',
         'sort_order'          => 'required|numeric|',
         'image'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = DoctorDescription::where('id', $id)->first();
        if ($data) {
            $data->name = $request->name;
            $data->qualification = $request->qualification;
            $data->description = $request->description;
            $data->sort_order = $request->sort_order;

            $DoctorDescription_image =$data->image;
            if($file = $request->file('image')) {
                $destinationPath    = UPLOADFILES.'doctor_descriptions/';
                if(!empty($request->old_image)){  
                    delete_file($request->old_image);
                } 
                $uploadImage        = time().'.'.$file->getClientOriginalExtension();
                $file->move($destinationPath, $uploadImage);
                $DoctorDescription_image = $destinationPath.$uploadImage;
            }
            $data->image = $DoctorDescription_image;
            
            $data->save();

            $request->session()->flash('success','DoctorDescription Update Successfully!!');
            return redirect(url('admin/doctor-descriptions'));
        }else {
            $request->session()->flash('error','DoctorDescription Does Not Exist!!');
            return redirect(url('admin/doctor-descriptions'));
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = DoctorDescription::where('id', $id)->delete();              
        }else{
            return 0;
        }
    }

    public function change_status(Request $request)
    {
        if ($request->ajax()) {
            $data = DoctorDescription::where('id', $request->id)->first();
            $data->status = $data->status==1?0:1;
            $data->save();
        }
    }
}
