<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Datatables;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
        checkPermission($this, 108);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $records = Category::select('categories.id', 'pcat.name as parent_name', 'categories.name', 'categories.status')
                ->leftJoin('categories as pcat', 'pcat.id', '=', 'categories.parent_id')
                ->where([['categories.deleted_at', null]])->get();

            return Datatables::of($records)
                ->addColumn('status', function ($row) {
                    $status = ($row->status == 1) ? 'checked' : '';
                    return $statusBtn = '<input class="tgl_checkbox tgl-ios"
                data-id="' . $row->id . '"
                id="cb_' . $row->id . '"
                type="checkbox" ' . $status . '><label for="cb_' . $row->id . '"></label>';
                })
                ->addColumn('action', function ($row) {
                    return $action_btn = '<a href="' . url('admin/categories/' . $row->id . '/edit') . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                    <button data-id="' . $row->id . '" class="btn btn-sm btn-danger delete_record"><i class="fa fa-trash"></i> Delete</button>';
                })
                ->editColumn('parent_name', function ($row) {
                    if ($row->parent_name == '') {
                        $par = 'Parent';
                    } else {
                        $par = $row->parent_name;
                    }
                    return $par;
                })

                ->removeColumn('id')
                ->rawColumns(['status', 'image', 'action'])->make(true);

        }
        $title = "Category";
        return view('admin.categories.index', compact('title'));
    }

    public function create()
    {
        $title = "Add Category";
        $category = new Category();
        $parcat = $category->getparentCat();
        return view('admin.categories.add', compact('title', 'parcat'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:100|unique:categories,name,NULL,id,deleted_at,NULL',
            'parent_id' => 'required',
            'sort_order' => 'required|numeric|',
            'image' => 'mimes:png,jpg,jpeg,JPG,JPEG,png|max:2048',
        ]);

        $data = new Category;
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', trim(str_replace(' - ', '-', $request->name)))));
        $data->parent_id = $request->parent_id;
        $data->name = $request->name;
        $data->sort_order = $request->sort_order;
        $data->slug = $slug;
        $data->is_featured = $request->is_featured;
        $data->sort_description = 'Sort Description';
        $data->status = 1;
        if (!empty($request->file('image'))) {
            $file = $request->file('image');
            $path = UPLOADFILES . "category/";
            if (!empty($request->old_image)) {
                delete_file($path . $request->old_image);
            }
            $uploadImage = time() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $uploadImage);
            $data->image = $path . $uploadImage;
        } else {
            $data->image = $request->old_image;
        }
        $data->save();
        $request->session()->flash('success', 'Category Added Successfully!!');
        return redirect(url('admin/categories'));
    }

    public function edit(Request $request, $id)
    {
        $title = "Edit Category";
        $data = Category::where('id', $id)->first();
        $category = new Category();
        $parcat = $category->getparentCat();
        if (!empty($data)) {
            return view('admin.categories.edit', compact('title', 'data', 'parcat'));
        } else {
            $title = "404 Error Page";
            $message = '<i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found!!';
            return view('admin.error', compact('title', 'message'));
        }
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => "required|max:100|unique:categories,name,$id,id,deleted_at,NULL",
            'parent_id' => 'required',
            'sort_order' => 'required|numeric|',
            'image' => 'mimes:png,jpg,jpeg,JPG,JPEG,png|max:2048',
        ]);

        $data = Category::where('id', $id)->first();
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', trim(str_replace(' - ', '-', $request->name)))));
        if ($data) {
            $data->parent_id = $request->parent_id;
            $data->name = $request->name;
            $data->sort_order = $request->sort_order;
            $data->slug = $slug;
            $data->is_featured = $request->is_featured;
            $data->sort_description = 'Sort Description';
            $data->status = 1;
            if (!empty($request->file('image'))) {
                $file = $request->file('image');
                $path = UPLOADFILES . "category/";
               
                if (!empty($request->old_image)) {
                    delete_file($request->old_image);
                }
                $uploadImage = time() . '.' . $file->getClientOriginalExtension();
                $file->move($path, $uploadImage);
                $data->image = $path . $uploadImage;
            } else {
                $data->image = $request->old_image;
            }
            $data->save();

            $request->session()->flash('success', 'Category Update Successfully!!');
            return redirect(url('admin/categories'));
        } else {
            $request->session()->flash('error', 'Category Does Not Exist!!');
            return redirect(url('admin/categories'));
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = Category::where('id', $id)->delete();
        } else {
            return 0;
        }
    }

    public function change_status(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::where('id', $request->id)->first();
            $data->status = $data->status == 1 ? 0 : 1;
            $data->save();
        }
    }
}
