<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Validator;
use App\Models\BlogCategory;
use Datatables;

class BlogCategoryController extends Controller
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
        checkPermission($this, 114);
    }

    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $records = BlogCategory::select('id','slug', 'name', 'status')->where([['deleted_at', NULL]])->get();

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
            
                        $action_btn .= '<a href="' . url('admin/blog_categories/' . $row->id . '/edit') . '" class="btn btn-sm btn-primary m-1" title="Edit"><i class="fa fa-edit"></i></a>';
                    
                
                        $action_btn .=   '<button data-id="' . $row->id . '" class="btn btn-sm btn-danger delete_record" title="Delete"><i class="fa fa-trash"></i></button>';
                   
                    return $action_btn;
                })
                ->removeColumn('id')
                ->rawColumns(['status', 'action'])->make(true);
        }
        $title = "Blog Category";
        return view('admin.blog_category.index', compact('title'));
    }

    public function create()
    {
        $title = "Add Blog Category";
        return view('admin.blog_category.add', compact('title'));
    }

    public function store(Request $request)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
        $validate = $request->validate([
            'name' => 'required',
        ]);
        $data = new BlogCategory;
        $data->slug = $slug;
        $data->name = $request->name;
        $data->status = 1;

        $data->save();
        $request->session()->flash('success', 'Blog Category Added Successfully!!');
        return redirect(url('admin/blog_categories'));
    }

    public function edit(Request $request, $id)
    {
        $title = "Edit Blog Category";
        $data = BlogCategory::where('id', $id)->first();
        if (!empty($data)) {
            return view('admin.blog_category.edit', compact('title', 'data'));
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
        ]);

        $data = BlogCategory::where('id', $id)->first();
        if ($data) {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));
            $data->slug = $slug;
            $data->name = $request->name;
           
            $data->save();
            $request->session()->flash('success', 'Blog Category Update Successfully!!');
            return redirect(url('admin/blog_categories'));
        } else {
            $request->session()->flash('error', 'Blog Category Does Not Exist!!');
            return redirect(url('admin/blog_categories'));
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = BlogCategory::where('id', $id)->delete();
        } else {
            return 0;
        }
    }

    public function change_status(Request $request)
    {
        if ($request->ajax()) {
            $data = BlogCategory::where('id', $request->id)->first();
            $data->status = $data->status == 1 ? 0 : 1;
            $data->save();
        }
    }

    
}
