<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\NewsletterMailJob;
use App\Mail\NewsletterMail;
use App\Models\NewsLetter;
use App\Models\NewsletterNotification;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class NewsLetternotificationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:admin');
        checkPermission($this, 121);
    }

    public function index(Request $request)
    {
   
        if ($request->ajax()) {
            $data = NewsletterNotification::get();

            return Datatables::of($data)
                ->editColumn('created_at', function ($row) {
                    return date('d-m-Y H:i A', strtotime($row['created_at']));
                })
                ->addColumn('action', function ($row) {
                    return $action_btn = '<button onClick="callModal(' . $row->id . ')" class="btn btn-sm btn-secondary" title="View"><i class="fas fa-eye"></i></button>&nbsp;
                <button data-id="' . $row->id . '" class="btn btn-sm btn-danger delete_record"  title="Delete"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['action','created_at'])
                ->make(true);
        }

        $title = "News Letter Notifications";
        return view('admin.newsletter_notifications.index', compact('title'));
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $content = NewsletterNotification::where('id', $id)->first();
            $data = '<ul class="list-group">
                        <li class="list-group-item">
                            <strong>Message : </strong>
                            <span class="text-break text-justify">' . $content->message . '</span>
                        </li>
                    </ul>';

            return $data;
        }
    }

    public function create()
    {
        // $data=[
        //     'subject' => 'test subject',
        //     'message' => 'test message',
        // ];
        // $mail=new NewsletterMail($data);
        // return $mail->render();
        $title = "Add News Letter Notification";  
        return view('admin.newsletter_notifications.add', compact('title'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
             'subject'              => 'required|max:250',
             'message'              => 'required',
        ]); 

        $data = new NewsletterNotification;
        $data->subject = $request->subject;
        $data->message = $request->message;
        $data->save();

        NewsletterMailJob::dispatch($data);

        $request->session()->flash('success','News Letter Added Successfully!!'); 
        return redirect( url('admin/newsletter-notifications'));
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = NewsletterNotification::where('id', $id)->delete();
            return 1;
        } else {
            return 0;
        }
    }

}
