<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsLetter;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class NewsLetterController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:admin');
        checkPermission($this, 107);
    }

    public function index(Request $request)
    {
   
        if ($request->ajax()) {
            $data = NewsLetter::get();

            return Datatables::of($data)
                ->editColumn('created_at', function ($row) {
                    return date('d-m-Y', strtotime($row['created_at']));
                })
                ->addColumn('action', function ($row) {
                    return $action_btn = '<button data-id="' . $row->id . '" class="btn btn-sm btn-danger delete_record"  title="Delete"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['action','created_at'])
                ->make(true);
        }

        $title = "News Letter";
        return view('admin.news_letter.index', compact('title'));
    }
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = NewsLetter::where('id', $id)->delete();
            return 1;
        } else {
            return 0;
        }
    }

}
