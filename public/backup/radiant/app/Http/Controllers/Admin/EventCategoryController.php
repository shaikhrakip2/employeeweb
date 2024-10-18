<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Validator;
use App\Models\EventCategory;
use Datatables;

class EventCategoryController extends Controller
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
        checkPermission($this, 112);
    }

    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $records = EventCategory::select('id','slug', 'name','image', 'status')->where([['deleted_at', NULL]])->get();
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
            
                        $action_btn .= '<a href="' . url('admin/event_categories/' . $row->id . '/edit') . '" class="btn btn-sm btn-primary m-1" title="Edit"><i class="fa fa-edit"></i></a>';
                    
                
                        $action_btn .=   '<button data-id="' . $row->id . '" class="btn btn-sm btn-danger delete_record" title="Delete"><i class="fa fa-trash"></i></button>';
                   
                    return $action_btn;
                })
                ->editColumn('image', function($row) {
                    return '<img src="'.asset($row->image).'" class="image logosmallimg">';
                })
                ->removeColumn('id')
                ->rawColumns(['status', 'action','image'])->make(true);
        }
        $title = "Event Category";
        return view('admin.event_category.index', compact('title'));
    }

    public function create()
    {
        $title = "Add Event Category";
        return view('admin.event_category.add', compact('title'));
    }

    public function store(Request $request)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
        $validate = $request->validate([
            'name'   => 'required|max:250|unique:event_categories,name',
            'image'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $data = new EventCategory;
        $data->slug = $slug;
        $data->name = $request->name;
        $data->status = 1;
        $event_category_image = '';
        if($file = $request->file('image')) {
            $destinationPath    = UPLOADFILES.'banners/'; 
            $uploadImage        = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $uploadImage);
            $event_category_image = $destinationPath.$uploadImage;
        }
        $data->image = $event_category_image;
        $data->save();
        $request->session()->flash('success', 'Event Category Added Successfully!!');
        return redirect(url('admin/event_categories'));
    }

    public function edit(Request $request, $id)
    {
        $title = "Edit Event Category";
        $data = EventCategory::where('id', $id)->first();
        if (!empty($data)) {
            return view('admin.event_category.edit', compact('title', 'data'));
        } else {
            $title = "404 Error Page";
            $message = '<i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found!!';
            return view('admin.error', compact('title', 'message'));
        }
    }

    public function update(Request $request, $id)
    {

        $validate = $request->validate([
            'name' => "required|max:191|unique:event_categories,name,{$id}",
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = EventCategory::where('id', $id)->first();
        if ($data) {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
            $data->slug = $slug;
            $data->name = $request->name;
            $event_category_image = $data->image;
            if($file = $request->file('image')) {
                $destinationPath    = UPLOADFILES.'banners/';
                if(!empty($request->old_image)){  
                    delete_file($request->old_image);
                } 
                $uploadImage = time().'.'.$file->getClientOriginalExtension();
                $file->move($destinationPath, $uploadImage);
                $event_category_image = $destinationPath.$uploadImage;
            }
            $data->image = $event_category_image;
            $data->save();
            $request->session()->flash('success', 'Event Category Update Successfully!!');
            return redirect(url('admin/event_categories'));
        } else {
            $request->session()->flash('error', 'Event Category Does Not Exist!!');
            return redirect(url('admin/event_categories'));
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = EventCategory::where('id', $id)->delete();
        } else {
            return 0;
        }
    }

    public function change_status(Request $request)
    {
        if ($request->ajax()) {
            $data = EventCategory::where('id', $request->id)->first();
            $data->status = $data->status == 1 ? 0 : 1;
            $data->save();
        }
    }

    
}
