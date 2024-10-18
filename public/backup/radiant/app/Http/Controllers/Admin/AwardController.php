<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Validator; 
use App\Models\Award;
use Yajra\DataTables\Facades\DataTables;

class AwardController extends Controller
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
        checkPermission($this, 118);
    }

   public function index(Request $request)
    {
        if($request->ajax()) {
            $records = Award::select('awards.*')->get();

            return DataTables::of($records)
            ->addColumn('status', function($row) {
                $status = ($row->status == 1)? 'checked': '';
                return $statusBtn = '<input class="tgl_checkbox tgl-ios" 
                data-id="'.$row->id.'" 
                id="cb_'.$row->id.'"
                type="checkbox" '.$status.'><label for="cb_'.$row->id.'"></label>';  
            })
            ->editColumn('date', function ($row) {
                return date('d-m-Y', strtotime($row['date']));
            })
            ->addColumn('action', function($row) {
                return $action_btn = '<a href="'.url('admin/awards/'.$row->id.'/edit').'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                    <button data-id="'.$row->id.'" class="btn btn-sm btn-danger delete_record"><i class="fa fa-trash"></i> Delete</button>'; 
            }) 
            ->editColumn('image', function($row) {
                return '<img src="'.asset($row->image).'" class="image logosmallimg">';
            })
            ->removeColumn('id') 
            ->rawColumns(['status','image','action','date'])->make(true);
        }
        $title = "Awards";
        return view('admin.award.index', compact('title'));
    }

    public function create()
    {
        $title = "Add Awards";    
        return view('admin.award.add', compact('title'));
    }

    public function store(Request $request)
    {
        // $validate = $request->validate([
        //     'title' => 'required|max:250|unique:awards,title',
        //     'date' => 'required|date',
        //     'short_description' => 'required|max:250',
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]); 
        $data = new Award;
        $data->title = $request->title;
        $data->date = $request->date;
        $data->short_description = $request->short_description;
        $data->status = 1;
        $award_image = '';
        if($file = $request->file('image')) {
            $destinationPath    = UPLOADFILES.'awards/'; 
            $uploadImage        = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $uploadImage);
            $award_image = $destinationPath.$uploadImage;
        }
        $data->image = $award_image;
        $data->save(); 

        $request->session()->flash('success','Award Added Successfully!!'); 
        return redirect( url('admin/awards'));
    }

    public function edit(Request $request, $id)
    {
        $title = "Edit Awards";   
        $data = Award::where('id', $id)->first();
        if(!empty($data)){
            return view('admin.award.edit', compact('title','data'));
        }else{
            $title = "404 Error Page";
            $message = '<i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found!!';
            return view('admin.error', compact('title','message'));
        }
    }

    public function update(Request $request, $id)
    { 
        $validate = $request->validate([
         'title' => "required|max:250|unique:awards,title,$id",
         'date' => 'required|date',
         'short_description' => 'required|max:250',
         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = Award::where('id', $id)->first();
        if($data) {
            $data->title = $request->title;
            $data->date = $request->date;
            $data->short_description = $request->short_description;

            $award_image = $data->image;
            if($file = $request->file('image')) {
                $destinationPath    = UPLOADFILES.'awards/';
                if(!empty($request->old_image)){  
                    delete_file($request->old_image);
                } 
                $uploadImage = time().'.'.$file->getClientOriginalExtension();
                $file->move($destinationPath, $uploadImage);
                $award_image = $destinationPath.$uploadImage;
            }
            $data->image = $award_image;
            $data->save();

            $request->session()->flash('success','Award Update Successfully!!');
            return redirect(url('admin/awards'));
        }else {
            $request->session()->flash('error','Award Does Not Exist!!');
            return redirect(url('admin/awards'));
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = Award::where('id', $id)->delete();              
        }else{
            return 0;
        }
    }

    public function change_status(Request $request)
    {
        if ($request->ajax()) {
            $data = Award::where('id', $request->id)->first();
            $data->status = $data->status==1?0:1;
            $data->save();
        }
    }


}
