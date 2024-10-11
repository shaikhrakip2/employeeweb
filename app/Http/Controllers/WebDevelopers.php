<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class WebDevelopers extends Controller
{
    public function create() {
        return view('create_user');
    }
    // public function store(Request $request) {
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required|min:6',
    //     ]);
    //     User::create($request->all());
    //     return redirect('users/store');
    // }
}
