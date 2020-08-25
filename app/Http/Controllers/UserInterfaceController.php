<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserInterfaceController extends Controller
{
    public function reviewDetails($id){
        return view('review-details');
    }
}
