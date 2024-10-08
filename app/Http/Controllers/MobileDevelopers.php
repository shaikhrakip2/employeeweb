<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MobileDeveloper;

class MobileDevelopers extends Controller
{

    public function adddevelopers(){
        return view('MobileDeveloper.addnewDevelopers');
    }
    
    public function developersviewtable(Request $request){
        $mobiledeveloper = MobileDeveloper::all();
        $data = compact('mobiledeveloper');
        return view('MobileDeveloper.developerViewTable')->with($data);
    }

    public function storedata(Request $request){
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
