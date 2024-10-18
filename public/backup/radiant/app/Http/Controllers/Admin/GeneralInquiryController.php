<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use App\Models\GeneralInquiry;

class GeneralInquiryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:admin');
        checkPermission($this, 119);
    }

    public function index(Request $request)
    {
   
        if ($request->ajax()) {
            $data = GeneralInquiry::get();

            return Datatables::of($data)
                ->editColumn('created_at', function ($row) {
                    return date('d-m-Y', strtotime($row['created_at']));
                })
                ->addColumn('action', function ($row) {
                    return $action_btn = '<button onClick="callModal(' . $row->id . ')" class="btn btn-sm btn-secondary" title="View"><i class="fas fa-eye"></i></button>&nbsp;
                <button data-id="' . $row->id . '" class="btn btn-sm btn-danger delete_record"  title="Delete"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $title = "General Inquires";
        return view('admin.general_inquires.index', compact('title'));
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $content = GeneralInquiry::where('id', $id)->first();
            if ($content->type == 1) {
                $cdata = 'General Inquiry';
            } elseif ($content->type == 2) {
                $cdata = 'Contact Inquiry';
            } else {
                $cdata = 'Unknown Inquiry Type';
            }
            $data = '<ul class="list-group">
                       
                        <li class="list-group-item">
                            <strong>Name : </strong>
                            <span class="text-break text-justify">' . $content->name . '</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Email-Address : </strong>
                            <span class="text-break text-justify">' . $content->email . '</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Mobile Number : </strong>
                            <span class="text-break text-justify">' . $content->mobile . '</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Message : </strong>
                            <span class="text-break text-justify">' . $content->message . '</span>
                        </li>
                    </ul>';

            return $data;
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = GeneralInquiry::where('id', $id)->delete();
            return 1;
        } else {
            return 0;
        }
    }
}
