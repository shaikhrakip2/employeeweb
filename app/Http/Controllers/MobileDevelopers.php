<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MobileDeveloper;

class MobileDevelopers extends Controller
{

    public function adddevelopers()
    {
        $citys = config('state');
        $d = compact('citys');
        return view('MobileDeveloper.addnewDevelopers')->with($d);
    }

    public function developersviewtable(Request $request)
    {
        $mobiledeveloper = MobileDeveloper::all();

        // $country = config('country');
        // echo "<pre>";
        // print_r($country);die;
        // $countries = json_decode('country',true);
        $citys = config('state');
        // echo "<pre>";
        // print_r($citys);exit;

        $data = compact('mobiledeveloper', 'citys');

        return view('MobileDeveloper.developerViewTable')->with($data);
    }

    public function storedata(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:mobile_developers,email',
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'working_experience' => 'nullable|integer|min:0'
        ]);
        $mobiledeveloper = new MobileDeveloper();
        $mobiledeveloper->name = $request->input('name');
        $mobiledeveloper->email = $request->input('email');
        $mobiledeveloper->phone = $request->input('phone');
        $mobiledeveloper->address = $request->input('address');
        $mobiledeveloper->designation = $request->input('designation');
        $mobiledeveloper->company = $request->input('company');
        $mobiledeveloper->working_experience = $request->input('working_experience');

        $mobiledeveloper->save();
        return redirect('/developerViewTable');
    }
}
