<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use App\Models\Faq;
use App\Models\FaqCategory;
use Nette\Utils\Random;
use Illuminate\Support\Str;

class FaqController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:admin');
        checkPermission($this, 111);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Faq::where('deleted_at',null)->get();

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function($data) {
                $status = ($data->status == 1)? 'checked': '';
                return $statusBtn = '<input class="tgl_checkbox tgl-ios" 
                data-id="'.$data->id.'" 
                id="cb_'.$data->id.'"
                type="checkbox" '.$status.'><label for="cb_'.$data->id.'"></label>';
            })
            ->addColumn('action', function($data) {
                return $action_btn = '<a href="'.url('admin/faq/'.$data->id.'/edit').'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                    <button data-id="'.$data->id.'" class="btn btn-sm btn-danger delete_record"><i class="fa fa-trash"></i></button>';
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }

        $title = "Faqs";
        return view('admin.faqs.index', compact('title'));
    }

    public function create(Request $request)
    {
        $title = "Add Faq";
        $data['level1_categories'] = FaqCategory::where(['status' => 1, 'deleted_at' => null])->get();
        
        //dd($data['level1_categories']);
        return view('admin.faqs.add', compact('title'),$data);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'category_1'        => 'required',
            'question'          => 'required',
            'answer'            => 'required',
            'sort_order'        => 'required',
        ]);

      
        $data = new Faq;
        $slug = RandcardStr(8);

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', Str::limit($request->question,10))));
        $data->faq_category_id  = $request->category_1;
        $data->question         = $request->question;
        $data->answer           = $request->answer;
        $data->slug             = $slug;
        $data->sort_order       = $request->sort_order;
        $data->save();

        $request->session()->flash('success','Faq Added Successfully!!'); 
        return redirect( url('admin/faq'));
    }

    public function edit(Request $request, $id)
    {
        $title = 'Edit Faq';
        // $data['level1_categories'] = FaqCategory::where(['status' => 1, 'deleted_at' => null])->get();
        $data = Faq::where('id', $id)->first();

        $parcat = FaqCategory::where(['status' => 1, 'deleted_at' => null])->get();
    
        if (!empty($data)) {
            return view('admin.faqs.edit', compact('title','data','parcat'));
        } else {
            $title = '404 Error Page';
            $message = '<i class="fas fa-exclamation-triangle text-warning"></i>Oops! Page Not Found!!';
            return view('admin.error', compact('title','message'));
        }
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'category_1'        => 'required',
            'question'          => 'required',
            'answer'            => 'required',
            'sort_order'        => 'required',
        ]);

        $data = Faq::where('id', $id)->first();
        if ($data) {
            // $faq_image = '';
            $faq_image =$data->image;
            if ($file = $request->file('image')) {
                $destinationPath    = UPLOADFILES.'faq/';
                if(!empty($request->old_image)){  
                    delete_file($request->old_image);
                } 
                $uploadImage        = time().'.'.$file->getClientOriginalExtension();
                $file->move($destinationPath, $uploadImage);
                $faq_image = $destinationPath.$uploadImage;
            }
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', trim($request->title))));
            $data->faq_category_id  = $request->category_1;
            $data->question         = $request->question;
            $data->answer           = $request->answer;
            $data->slug             = $slug;
            $data->sort_order       = $request->sort_order;
            $data->save();

            $request->session()->flash('success','Faq Updated Successfully!!'); 
            return redirect( url('admin/faq'));
        } else {
            $request->session()->flash('error', 'Faq Does Not Exist!!');
            return redirect(url('admin/faq'));
        }
    }

    public function change_status(Request $request)
    {
        if ($request->ajax()) {
            $data = Faq::where('id', $request->id)->first();
            $data->status = $data->status==1?0:1;
            $data->save();
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = Faq::where('id', $id)->delete();              
        }else{
            return 0;
        }
    }
}
