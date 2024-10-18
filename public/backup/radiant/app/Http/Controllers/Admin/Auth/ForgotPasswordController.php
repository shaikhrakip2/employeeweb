<?php

namespace App\Http\Controllers\Admin\Auth;

use Auth;
use Password;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\Admin;
use Mail;


class ForgotPasswordController extends Controller
{
    
    /**
     * Only guests for "admin" guard are allowed except
     * for logout.
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['guest:admin','mail']);
    }

    /**
     * Show the reset email form.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm(){
        return view('admin.auth.passwords.email',[
            'title' => 'Admin Password Reset',
            'passwordEmailRoute' => 'admin.password.email'
        ]);
    }

    /**
     * password broker for admin guard.
     * 
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker(){
        return Password::broker('admins');
    }

    /**
     * Get the guard to be used during authentication
     * after password reset.
     * 
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    public function guard(){
        return Auth::guard('admin');
    }


    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = Admin::where('email', request()->input('email'))->first();
        if (is_null($user)) {
            return back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans("We can't find a user with that email address.")]);
        }
        if(!is_null($user)) {
            $token = Password::getRepository()->create($user);
            $data = array('token' => $token);

            $email = $user->email; 
            $actionUrl = route('admin.password.reset', $token).'?email='.$email.'';  
            $offer = [
                'user' => $user->name,
                'title' => config('app.name') . ' Password Reset Link',
                'subject' => config('app.name') . ' Password Reset Link',
                'actionText' => 'Reset Password',
                'color'=>'#2d3748',
                'actionUrl' => $actionUrl,
                'introLines' => 'You are receiving this email because we received a password reset request for your account.',
                'outroLines' => 'This password reset link will expire in 60 minutes.<br><br>If you did not request a password reset, no further action is required.', 
            ];
      
            Mail::to($email)->send(new ResetPasswordMail($offer)); 
            if( count(Mail::failures()) > 0 ) { 
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans("Email can't be send, Please  retrying after some time.")]);
            } else { 
                return back()->with('status', trans("We have emailed your password reset link!"));
            } 
        }
    }
 

}
