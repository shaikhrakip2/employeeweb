<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Validator; 
use App\Models\Team; 
use Yajra\DataTables\Facades\DataTables;

class TeamController extends Controller
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
        checkPermission($this, 117);
    }


    public function index(Request $request)
    {
        if($request->ajax()) {
            $records = Team::select('id','name','type','designation','image', 'status')->where([['deleted_at', NULL]])->get();

            return Datatables::of($records)
            ->addColumn('status', function($row) {
                $status = ($row->status == 1)? 'checked': '';
                return $statusBtn = '<input class="tgl_checkbox tgl-ios" 
                data-id="'.$row->id.'" 
                id="cb_'.$row->id.'"
                type="checkbox" '.$status.'><label for="cb_'.$row->id.'"></label>';  
            })
            ->addColumn('action', function($row) {
                return $action_btn = '<a href="'.url('admin/team/'.$row->id.'/edit').'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                <button data-id="'.$row->id.'" class="btn btn-sm btn-danger delete_record"><i class="fa fa-trash"></i> Delete</button>'; 
            }) 
            ->editColumn('image', function($row) {
                return '<img src="'.asset($row->image).'" class="image logosmallimg">';
            })
            ->removeColumn('id') 
            ->rawColumns(['status','image','action'])->make(true);
        }
        $title = "Teams";
        return view('admin.team.index', compact('title'));
    }


    public function create()
    {
        $title = "Add Team";  
        return view('admin.team.add', compact('title'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
             'name'                 => 'required|max:250|unique:teams,name',
             'type'                 => 'required',
             'designation'          => 'required|max:250',
             'sort_description'     => 'required|max:250',
             'sort_order'           => 'required|numeric|',
             'image'                => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]); 

        $data = new Team;
        $data->name = $request->name;
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
        $data->slug = $slug;
        $data->type = $request->type;
        $data->designation = $request->type == 1 ? $request->designation : 'Volunteer';
        $data->sort_description = $request->sort_description;
        $data->sort_order = $request->sort_order;
        $Team_image =$data->image;
        if($file = $request->file('image')) {
            $destinationPath    = UPLOADFILES.'team/';
            if(!empty($request->old_image)){  
                delete_file($destinationPath.$request->old_image);
            } 
            $uploadImage        = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $uploadImage);
            $Team_image = $destinationPath.$uploadImage;
        }
        $data->image = $Team_image; 
        $data->save();


        $request->session()->flash('success','Team Added Successfully!!'); 
        return redirect( url('admin/team'));
    }



    public function edit(Request $request, $id)
    {
        $title = "Edit Team";   
        $data = Team::where('id', $id)->first();
        if(!empty($data)){
            return view('admin.team.edit', compact('title','data'));
        }else{
            $title = "404 Error Page";
            $message = '<i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found!!';
            return view('admin.error', compact('title','message'));
        }
    }

    public function update(Request $request, $id)
    { 
        $validate = $request->validate([
         'name'                 => "required|max:250|unique:teams,name,$id",
         'type'                 => 'required',
         'designation'          => 'required|max:250',
         'sort_description'     => 'required|max:250',
         'sort_order'           => 'required|numeric|',
         'image'                => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = Team::where('id', $id)->first();
        if ($data) {
            $data->name = $request->name;
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
            $data->slug = $slug;
            $data->type = $request->type;
            $data->designation = $request->type == 1 ? $request->designation : 'Volunteer';
            $data->sort_description = $request->sort_description;
            $data->sort_order = $request->sort_order;

            $Team_image =$data->image;
            if($file = $request->file('image')) {
                $destinationPath    = UPLOADFILES.'team/';
                if(!empty($request->old_image)){  
                    delete_file($request->old_image);
                } 
                $uploadImage        = time().'.'.$file->getClientOriginalExtension();
                $file->move($destinationPath, $uploadImage);
                $Team_image = $destinationPath.$uploadImage;
            }
            $data->image = $Team_image;
            
            $data->save();

            $request->session()->flash('success','Team Update Successfully!!');
            return redirect(url('admin/team'));
        }else {
            $request->session()->flash('error','Team Does Not Exist!!');
            return redirect(url('admin/team'));
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = Team::where('id', $id)->delete();              
        }else{
            return 0;
        }
    }

    public function change_status(Request $request)
    {
        if ($request->ajax()) {
            $data = Team::where('id', $request->id)->first();
            $data->status = $data->status==1?0:1;
            $data->save();
        }
    }
}
