<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\NewsLetter;
use Illuminate\Http\Request;

class NewsLetterController extends Controller
{
    public function submit_newsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            $data = new NewsLetter();
            $data->email = $request->email;
            $data->save();

            $request->session()->flash('success', 'Thanks For Subscribing To Our Newsletter.');
            return redirect()->route('home');
        } catch (\Exception $e) {
            $request->session()->flash('error', 'Please enter a valid email address!!');
            $errorMessage = 'Failed to save contact inquiry: ' . $e->getMessage();
            return redirect()->back()->with('error', $errorMessage);
        }
    }
}
