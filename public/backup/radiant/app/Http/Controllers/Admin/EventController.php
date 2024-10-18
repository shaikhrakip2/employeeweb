<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use App\Models\Event;
use App\Models\EventCategory;

class EventController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:admin');
        checkPermission($this, 113);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Event::select('id','title','image','date','status','sort_description')->where('deleted_at',null)->get();

            return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('image',function($data) {
                return '<a href="'.asset($data->image).'" target="_blank"><img src="'.asset($data->image).'" alt="Image Not Found" class="rounded-circle" style="width: 40px; height: 40px" /></a>';
            })
            ->addColumn('status', function($data) {
                $status = ($data->status == 1)? 'checked': '';
                return $statusBtn = '<input class="tgl_checkbox tgl-ios" 
                data-id="'.$data->id.'" 
                id="cb_'.$data->id.'"
                type="checkbox" '.$status.'><label for="cb_'.$data->id.'"></label>';
            })
            ->addColumn('action', function($data) {
                return $action_btn = '<a href="'.url('admin/event/'.$data->id.'/edit').'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                    <button data-id="'.$data->id.'" class="btn btn-sm btn-danger delete_record"><i class="fa fa-trash"></i></button>';
            })
            ->rawColumns(['image','status','action'])
            ->make(true);
        }

        $title = "Events";
        return view('admin.events.index', compact('title'));
    }

    public function create(Request $request)
    {
        $title = "Add Event";
        $data['level1_categories'] = EventCategory::where(['status' => 1, 'deleted_at' => null])->get();

        //dd($data['level1_categories']);
        return view('admin.events.add', compact('title'),$data);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'title'             => 'required|max:250|unique:events,title',
            'category_1'        => 'required',
            'date'              => 'required|date',
            'sort_order'        => 'required',
            'image'             => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
            'sort_description'  => 'required|max:250',
            'description'       => 'required',
            
        ]);

        $event_image = '';
        if ($file = $request->file('image')) {
            $destinationPath    = UPLOADFILES.'event/';
            $uploadImage        = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $uploadImage);
            $event_image = $destinationPath.$uploadImage;
        }

    
        $data = new Event;
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title)));
        $data->category_id      = $request->category_1;
        $data->title            = $request->title;
        $data->slug             = $slug;
        $data->date             = $request->date;
        $data->sort_order       = $request->sort_order;
        $data->image            = $event_image;
        $data->sort_description = $request->sort_description;
        $data->description      = $request->description;
        $data->save();

        $request->session()->flash('success','Event Added Successfully!!'); 
        return redirect( url('admin/event'));
    }

    public function edit(Request $request, $id)
    {
        $title = 'Edit Event';
        // $data['level1_categories'] = EventCategory::where(['status' => 1, 'deleted_at' => null])->get();
        $data = Event::where('id', $id)->first();

        $parcat = EventCategory::where(['status' => 1, 'deleted_at' => null])->get();
    
        if (!empty($data)) {
            return view('admin.events.edit', compact('title','data','parcat'));
        } else {
            $title = '404 Error Page';
            $message = '<i class="fas fa-exclamation-triangle text-warning"></i>Oops! Page Not Found!!';
            return view('admin.error', compact('title','message'));
        }
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'title'             => "required|unique:events,title,{$id}",
            'category_1'        => 'required',
            'date'              => 'required', 
            'sort_order'        => 'required', 
            'sort_description'  => 'required',
            'description'       => 'required',
            'image'             => 'image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $data = Event::where('id', $id)->first();
        if ($data) {
            // $event_image = '';
            $event_image =$data->image;
            if ($file = $request->file('image')) {
                $destinationPath    = UPLOADFILES.'event/';
                if(!empty($request->old_image)){  
                    delete_file($request->old_image);
                } 
                $uploadImage        = time().'.'.$file->getClientOriginalExtension();
                $file->move($destinationPath, $uploadImage);
                $event_image = $destinationPath.$uploadImage;
            }
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', trim($request->title))));
            $data->category_id      = $request->category_1;
            $data->title            = $request->title;
            $data->date             = $request->date;
            $data->slug             = $slug;
            $data->sort_order       = $request->sort_order;
            $data->sort_description = $request->sort_description;
            $data->description      = $request->description;
            $data->image = $event_image;
            $data->save();

            $request->session()->flash('success','Event Updated Successfully!!'); 
            return redirect( url('admin/event'));
        } else {
            $request->session()->flash('error', 'Event Does Not Exist!!');
            return redirect(url('admin/event'));
        }
    }

    public function change_status(Request $request)
    {
        if ($request->ajax()) {
            $data = Event::where('id', $request->id)->first();
            $data->status = $data->status==1?0:1;
            $data->save();
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = Event::where('id', $id)->delete();              
        }else{
            return 0;
        }
    }
}
