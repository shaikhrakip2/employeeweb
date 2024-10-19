<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Auth\Events\Validated;
use Termwind\Components\Raw;


class UserController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function index(Request $request)
    {
        $users = User::all();
        // echo "<pre>";
        // print_r($users);die;
        $data = compact('users');
        return view('index')->with($data);
    }

    public function edituser($id)
    {
        $users = User::find($id);
        $data = compact('users');
        return view('UserEditForm.useredit')->with($data);
    }
    public function storeedituser($id, Request $request)
    {

        $users = User::find($id);
        $users->name = $request->input('name');
        $users->email = $request->input('email');
        $users->save();

        session()->flash('success', 'User  ' . $users->name . ' updated successfully');

        return redirect('/dashboard');
    }


    public function userdestroy($id)
    {
        $user = User::find($id);
        // if (!$user) {
        //     return redirect('/dashboard');
        // } else {
        //     $user->delete();
        // }
        $user->delete();
       
        
        return redirect('/dashboard');
    }


    

    // end user



    public function addnewemployee()
    {
        return view('addemployee.createNewEmployee');
    }



    public function storenewemployee(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'city' => 'required',
            'state' => 'required',
        ]);

        // Check if the request has an image
        if ($request->hasFile('image')) {
            try {
                // Store the image and get the path
                $imagePath = $request->file('image')->store('images', 'public');

                // Create a new employee record
                $user = new Employee();
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->mobile = $request->input('mobile');
                $user->image = $imagePath;
                $user->city = $request->input('city');
                $user->state = $request->input('state');
                $user->save();

                // Redirect with success message
                return redirect('totalemployee')->with('success', 'Employee created successfully!');
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['image' => 'Failed to upload image.']);
            }
        }

        // If no image was uploaded, return an error response
        return redirect()->back()->withErrors(['image' => 'Image is required.']);
    }













    // public function totalemployee(Request $request)
    // {



    //     $search = $request['search'] ?? "";
    //     if ($search != "") {
    //         $users = Employee::where('name' , 'like', "{$search}%")->get();
    //     } else {
    //         $users = Employee::all();
    //     }


    //     // echo "<pre>";
    //     // print_r($users);die;
    //     $data = compact('users', 'search');
    //     return view('totalEmployee.totalemployee')->with($data);
    // }





    public function totalemployee(Request $request)
    {
        $search = $request->input('search', "");
        $users = [];

        if ($search != "") {
            $users = Employee::where('name', 'like', "{$search}%")->get();
        } else {
            $users = Employee::all();
        }
               

        $message = count($users) > 0 ? 'Search completed successfully.' : 'No results found..';
        
        $data = compact('users', 'search','message');
        return view('totalEmployee.totalemployee')->with($data);

    }







    // edit employee
    public function editemployee($id)
    {
        $user = Employee::find($id);
        $data = compact('user');
        return view('editEmployee.editemployee')->with($data);
    }



    public function updateemployee(Request $request, $id)
    {
        $user = Employee::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');

        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->save();

        return redirect('/totalemployee');
    }


    public function deleteemployee($id)
    {
        $user = Employee::find($id);
        $user->delete();

        return redirect('/totalemployee');
    }





    public function viewemployeedata($id)
    {

        $user = Employee::find($id);
        // echo "<pre>";    
        // print_r($user);die;
        $users = compact('user');
        return view('viewemployeedata.viewemployeedata')->with($users);
    }
}
