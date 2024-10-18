<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Validator; 
use App\Models\HomeCms; 
use Yajra\DataTables\Facades\DataTables;


class HomeCmsController extends Controller
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
        checkPermission($this, 105);
    
    }

   public function index(Request $request)
    {

    
        if($request->ajax()) {
       
            $records = HomeCms::select('id','name','cms_contant1')->get();

            return Datatables::of($records)
    
            ->addColumn('action', function($row) {
                return $action_btn = '<a href="'.url('admin/home_cms/'.$row->id.'/edit').'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>'; 
            }) 
            ->removeColumn('id') 
            ->rawColumns(['action'])->make(true);
        }
        $title = "Home Cms";
        return view('admin.home_cms.index', compact('title'));
    }


    public function edit(Request $request, $id)
    {
        $title = "Edit Home Cms";   
        $data = HomeCms::where('id', $id)->first();

        if(!empty($data)){
            return view('admin.home_cms.edit', compact('title','data','id'));
        }else{
            $title = "404 Error Page";
            $message = '<i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found!!';
            return view('admin.error', compact('title','message'));
        }
    }

    public function update(Request $request, $id)
    { 
            $validate = $request->validate([
             'name' => "required|max:100|unique:home_cms,name,$id",
             'cms_contant'  => 'required',
             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
        $data = HomeCms::where('id', $id)->first();
        if($data) {
            $data->name = $request->name;
            $data->cms_contant1 = $request->cms_contant;

            $cms_image =$data->image;
            if($file = $request->file('image')) {
                $destinationPath    = UPLOADFILES.'cms/';
                if(!empty($request->old_image)){  
                    delete_file($request->old_image);
                } 
                $uploadImage        = time().'.'.$file->getClientOriginalExtension();
                $file->move($destinationPath, $uploadImage);
                $cms_image = $destinationPath.$uploadImage;
            }
            $data->image = $cms_image;
            
            $data->save();

            $request->session()->flash('success','Home Cms Update Successfully!!');
            return redirect(url('admin/home_cms'));
        }else {
            $request->session()->flash('error','Home Cms Does Not Exist!!');
            return redirect(url('admin/home_cms'));
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = HomeCms::where('id', $id)->delete();              
        }else{
            return 0;
        }
    }

    public function change_status(Request $request)
    {
        if ($request->ajax()) {
            $data = HomeCms::where('id', $request->id)->first();
            $data->status = $data->status==1?0:1;
            $data->save();
        }
    }


}

