<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Validator;
use App\Models\Certification;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class CertificationController extends Controller
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
        checkPermission($this,118);
    }

    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $records = Certification::select('id','name','image','status')->where([['deleted_at', NULL]])->get();

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
            
                        $action_btn .= '<a href="' . url('admin/certificate/' . $row->id . '/edit') . '" class="btn btn-sm btn-primary m-1" title="Edit"><i class="fa fa-edit"></i></a>';
                    
                
                        $action_btn .=   '<button data-id="' . $row->id . '" class="btn btn-sm btn-danger delete_record" title="Delete"><i class="fa fa-trash"></i></button>';
                   
                    return $action_btn;
                })
                ->editColumn('image', function ($row) {
                    return '<img src="' . asset($row->image) . '" class="image logosmallimg">';
                })
                ->removeColumn('id')
                ->rawColumns(['status', 'image', 'action'])->make(true);
        }
        $title = "Certification";
        return view('admin.certificate.index', compact('title'));
    }

    public function create()
    {
        $title = "Add Certificate";
        return view('admin.certificate.add', compact('title'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $data = new Certification;

        $data->name = $request->name;
        $data->issue_date = '2024-01-27';
        $data->status = 1;
        $Category_image = '';
        $destinationPath    = UPLOADFILES . 'certificate/';
        if ($file = $request->file('image')) {
            $uploadImage        = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $uploadImage);
            $Category_image = $destinationPath . $uploadImage;
            $data->image = $Category_image;
        }
        $data->save();
        $request->session()->flash('success', 'Certificate Added Successfully!!');
        return redirect(url('admin/certificate'));
    }

    public function edit(Request $request, $id)
    {
        $title = "Edit Certificate";
        $data = Certification::where('id', $id)->first();
        if (!empty($data)) {
            return view('admin.certificate.edit', compact('title', 'data'));
        } else {
            $title = "404 Error Page";
            $message = '<i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found!!';
            return view('admin.error', compact('title', 'message'));
        }
    }

    public function update(Request $request, $id)
    {

        $validate = $request->validate([
            'name' => "required",
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = Certification::where('id', $id)->first();
        if ($data) {
            $data->name = $request->name;

            $Category_image =$data->image;
            if ($file = $request->file('image')) {
                $destinationPath    = UPLOADFILES.'certificate/';
                if(!empty($request->old_image)){  
                    delete_file($request->old_image);
                } 
                $uploadImage        = time().'.'.$file->getClientOriginalExtension();
                $file->move($destinationPath, $uploadImage);
                $Category_image = $destinationPath.$uploadImage;
            }
            $data->image = $Category_image;
           
            $data->save();
            $request->session()->flash('success', 'Certificate Update Successfully!!');
            return redirect(url('admin/certificate'));
        } else {
            $request->session()->flash('error', 'Certificate Does Not Exist!!');
            return redirect(url('admin/certificate'));
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = Certification::where('id', $id)->delete();
        } else {
            return 0;
        }
    }

    public function change_status(Request $request)
    {
        if ($request->ajax()) {
            $data = Certification::where('id', $request->id)->first();
            $data->status = $data->status == 1 ? 0 : 1;
            $data->save();
        }
    }

    
}
